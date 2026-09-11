<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CachedTest;
use App\Models\DashboardTests;
use App\Models\DashboardTestsDetails;
use App\Models\LighthouseResult;
use App\Models\LighthouseTest;
use App\Models\Projects;
use App\Models\TestLabel;
use App\Models\TestResults;
use App\Models\User;
use App\Models\UserActionEvent;
use App\Services\TestContextService;
use App\Support\LighthouseUrlParser;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MonitoringController extends Controller
{
    private const SOURCE_BULK_TOOL = 'Bulk tool';

    private const SOURCE_ANALYSIS_PAGE = 'Analysis page';

    private const SOURCE_DASHBOARD = 'Dashboard';

    private const SOURCE_GOOGLE_LIGHTHOUSE = 'Google Lighthouse';

    private const SOURCE_DASHBOARD_RECHECK = 'Dashboard Recheck';

    private const SOURCE_DASHBOARD_PREPARATION = 'Dashboard Preparation';

    private const SOURCE_DASHBOARD_PAGESPEED_PREPARATION = 'Dashboard Page speed preparation';

    private const SOURCE_DASHBOARD_WIDGET = 'Dashboard Widget';

    private const TYPE_NEW_ACCOUNT = 'New account';

    public function tests(Request $request)
    {
        $date = $request->input('date');
        $status = $request->input('status');
        $rows = collect()
            ->merge($this->cachedTestRows($date))
            ->merge($this->testResultRows($date))
            ->merge($this->dashboardTestRows($date))
            ->merge($this->lighthouseRows($date))
            ->sortByDesc('date')
            ->values();

        if (in_array($status, ['success', 'failed'], true)) {
            $rows = $rows->where('result', $status)->values();
        }

        return view('admin.monitoring.tests', [
            'rows' => $rows->take(500),
            'date' => $date,
            'status' => $status,
        ]);
    }

    public function activity(Request $request)
    {
        $date = $request->input('date');
        $status = $request->input('status');

        $events = UserActionEvent::with('user')->latest();
        if ($date) {
            $events->whereDate('created_at', $date);
        }
        if (in_array($status, ['success', 'failed', 'info'], true)) {
            $events->where('status', $status);
        }

        $signups = User::withTrashed()->latest();
        if ($date) {
            $signups->whereDate('created_at', $date);
        }

        return view('admin.monitoring.activity', [
            'events' => $events->limit(500)->get(),
            'signups' => $signups->limit(200)->get(),
            'date' => $date,
            'status' => $status,
        ]);
    }

    public function error(string $source, int $id)
    {
        $error = $this->resolveErrorPayload($source, $id);
        abort_if(! $error, 404);

        return view('admin.monitoring.error', $error);
    }

    protected function cachedTestRows(?string $date): Collection
    {
        $query = CachedTest::latest();
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        return $query->limit(200)->get()->map(function (CachedTest $test) {
            $context = [
                'result' => $test->result,
                'resultsData' => $test->resultsData,
                'dataFailed' => $test->dataFailed,
                'dataPassed' => $test->dataPassed,
            ];
            $failed = $this->hasFailures($test->dataFailed) || $this->hasFailures($test->result);

            return [
                'date' => $test->created_at,
                'url' => $test->projectUrl ?: 'Not captured',
                'type' => $test->web_app ? 'Webapp Analysis' : 'Webpage Analysis',
                'source' => self::SOURCE_ANALYSIS_PAGE,
                'result' => $failed ? 'failed' : 'success',
                'cached_url' => url(($test->web_app ? 'analysis-report/' : 'analysis-report/w/') . $test->test_key),
                'error_url' => $failed ? route('admin.tests.error', ['source' => 'cached', 'id' => $test->id]) : null,
                'error_preview' => $failed ? $this->summarizeContext($context) : null,
            ];
        });
    }

    protected function testResultRows(?string $date): Collection
    {
        $query = TestResults::latest();
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        return $query->limit(200)->get()->map(function (TestResults $test) {
            $data = $this->decode($test->data);
            $failed = $this->hasFailures($data);
            $source = $this->resolveTestResultSource($test);

            return [
                'date' => $test->created_at,
                'url' => $test->url,
                'type' => $test->project_id ? 'Webapp Analysis' : 'Webpage Analysis',
                'source' => $source,
                'result' => $failed ? 'failed' : 'success',
                'cached_url' => $source === self::SOURCE_BULK_TOOL
                    ? null
                    : url('analysis-report/w/' . $test->ref_id),
                'error_url' => $failed ? route('admin.tests.error', ['source' => 'test-result', 'id' => $test->id]) : null,
                'error_preview' => $failed ? $this->summarizeContext($data) : null,
            ];
        });
    }

    protected function dashboardTestRows(?string $date): Collection
    {
        // Rechecks reuse one dashboard_tests row, so admin history must come from
        // each start event (otherwise only the original prep date is visible).
        $query = UserActionEvent::query()
            ->where('action', 'dashboard_test_start')
            ->where('status', 'success')
            ->latest();

        if ($date) {
            $query->whereDate('created_at', $date);
        }

        $events = $query->limit(200)->get();
        $latestEventIdByProject = $events
            ->groupBy(fn (UserActionEvent $event) => (int) ($event->subject_id ?? 0))
            ->map(fn (Collection $group) => optional($group->sortByDesc('id')->first())->id);

        $dashboardByProject = DashboardTests::query()
            ->whereIn('project_id', $events->pluck('subject_id')->filter()->unique()->all())
            ->with('dashboardTestsDetails')
            ->latest()
            ->get()
            ->groupBy('project_id')
            ->map->first();

        return $events->map(function (UserActionEvent $event) use ($latestEventIdByProject, $dashboardByProject) {
            $context = is_array($event->context) ? $event->context : [];
            $testType = (string) ($context['test_type'] ?? 'default');
            $recheckLabel = $context['recheck_label'] ?? null;
            $urlCount = (int) ($context['url_count'] ?? 0);
            $projectId = (int) ($event->subject_id ?? 0);
            $dashboard = $dashboardByProject->get($projectId);
            $isLatestForProject = $latestEventIdByProject->get($projectId) === $event->id;

            [$type, $source] = $this->resolveDashboardEventLabels($testType, is_string($recheckLabel) ? $recheckLabel : null);
            [$result, $errorUrl, $errorPreview] = $this->resolveDashboardEventResult(
                $dashboard,
                $isLatestForProject,
                $urlCount
            );

            return [
                'date' => $event->created_at,
                'url' => $this->formatDashboardEventUrl($dashboard, $projectId, $urlCount),
                'type' => $type,
                'source' => $source,
                'result' => $result,
                'cached_url' => null,
                'error_url' => $errorUrl,
                'error_preview' => $errorPreview,
            ];
        });
    }

    /**
     * @return array{0: string, 1: string}
     */
    protected function resolveDashboardEventLabels(string $testType, ?string $recheckLabel): array
    {
        if ($testType === 'single_recheck') {
            return [
                'Account / ' . $this->resolveDashboardWidgetName($recheckLabel),
                self::SOURCE_DASHBOARD_WIDGET,
            ];
        }

        if ($testType === 'recheck') {
            return ['Full Website Re-check', self::SOURCE_DASHBOARD_RECHECK];
        }

        return [self::TYPE_NEW_ACCOUNT, self::SOURCE_DASHBOARD_PREPARATION];
    }

    /**
     * @return array{0: string, 1: ?string, 2: ?string}
     */
    protected function resolveDashboardEventResult(?DashboardTests $dashboard, bool $isLatestForProject, int $urlCount): array
    {
        if (! $isLatestForProject || ! $dashboard) {
            return ['success', null, null];
        }

        $details = $dashboard->dashboardTestsDetails;
        $failedCount = $details->filter(function (DashboardTestsDetails $detail) {
            return $detail->status === 'failed' || (bool) $detail->error_message;
        })->count();

        $pendingCount = $details->filter(function (DashboardTestsDetails $detail) {
            return ! in_array($detail->status, ['completed', 'failed'], true);
        })->count();

        if ($failedCount > 0) {
            return [
                'failed',
                route('admin.tests.error', ['source' => 'dashboard-run', 'id' => $dashboard->id]),
                $failedCount . ' of ' . max($urlCount, $details->count(), 1) . ' URL checks failed in this run.',
            ];
        }

        if ($pendingCount > 0 || in_array($dashboard->status, ['pending', 'in_progress', 'recheck', 'recheck-single'], true)) {
            return ['pending', null, null];
        }

        return ['success', null, null];
    }

    protected function formatDashboardEventUrl(?DashboardTests $dashboard, int $projectId, int $urlCount): string
    {
        if ($urlCount > 1) {
            return $urlCount . ' URLs';
        }

        if ($dashboard) {
            $runUrls = json_decode($dashboard->urls ?? '[]', true);
            if (is_array($runUrls) && isset($runUrls[0]) && is_string($runUrls[0]) && $runUrls[0] !== '') {
                return $runUrls[0];
            }

            $detailUrl = optional($dashboard->dashboardTestsDetails->first())->url;
            if ($detailUrl) {
                return $detailUrl;
            }
        }

        $homepage = Projects::where('id', $projectId)->value('homepage');

        return $homepage ?: '1 URL';
    }

    protected function resolveDashboardWidgetName(?string $recheckLabel): string
    {
        if (! $recheckLabel || $recheckLabel === 'na') {
            return 'Widget';
        }

        $label = TestLabel::where('db_name', $recheckLabel)->value('display_name');
        if ($label) {
            return (string) $label;
        }

        return Str::title(str_replace(['_', '-'], ' ', $recheckLabel));
    }

    protected function lighthouseRows(?string $date): Collection
    {
        // One admin row per page-speed run (not per URL / strategy), matching
        // how dashboard prep is shown as a single "N URLs" action.
        $query = LighthouseTest::with('results')->latest();
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        return $query->limit(200)->get()->map(function (LighthouseTest $run) {
            $urls = LighthouseUrlParser::fromStoredJson($run->urls);
            $urlCount = count($urls);
            $results = $run->results;

            $failedCount = $results->filter(function (LighthouseResult $result) {
                return $result->status === 'failed' || (bool) $result->error_message;
            })->count();

            $pendingCount = $results->filter(function (LighthouseResult $result) {
                return ! in_array($result->status, ['completed', 'failed'], true);
            })->count();

            if ($failedCount > 0 || $run->status === 'failed') {
                $result = 'failed';
            } elseif ($pendingCount > 0 || $run->status !== 'completed') {
                $result = 'pending';
            } else {
                $result = 'success';
            }

            $isPreparation = $this->isDashboardPagespeedPreparation($run);

            return [
                'date' => $run->created_at,
                'url' => $urlCount === 1 ? ($urls[0] ?? 'Not captured') : ($urlCount . ' URLs'),
                'type' => $isPreparation ? self::TYPE_NEW_ACCOUNT : 'Google PageSpeed Lighthouse',
                'source' => $isPreparation
                    ? self::SOURCE_DASHBOARD_PAGESPEED_PREPARATION
                    : self::SOURCE_GOOGLE_LIGHTHOUSE,
                'result' => $result,
                'cached_url' => null,
                'error_url' => $failedCount > 0
                    ? route('admin.tests.error', ['source' => 'lighthouse-run', 'id' => $run->id])
                    : null,
                'error_preview' => $failedCount > 0
                    ? ($failedCount . ' of ' . max($results->count(), 1) . ' page-speed checks failed in this run.')
                    : null,
            ];
        });
    }

    protected function isDashboardPagespeedPreparation(LighthouseTest $run): bool
    {
        if (! $run->project_id) {
            return false;
        }

        // First page-speed run for a project is the new-account dashboard prep.
        return ! LighthouseTest::where('project_id', $run->project_id)
            ->where('id', '<', $run->id)
            ->exists();
    }

    protected function resolveTestResultSource(TestResults $test): string
    {
        if ($this->isBulkToolTest($test)) {
            return self::SOURCE_BULK_TOOL;
        }

        return match ($test->settings_mode) {
            TestContextService::MODE_ANALYSIS,
            TestContextService::MODE_SNAPSHOT,
            TestContextService::MODE_PROJECT,
            TestContextService::MODE_DEFAULT => self::SOURCE_ANALYSIS_PAGE,
            default => self::SOURCE_ANALYSIS_PAGE,
        };
    }

    protected function isBulkToolTest(TestResults $test): bool
    {
        if ($test->settings_mode === TestContextService::MODE_BULK) {
            return true;
        }

        if ($test->settings_mode !== TestContextService::MODE_SNAPSHOT) {
            return false;
        }

        $decoded = json_decode($test->testLabels ?? '', true);
        if (! is_array($decoded)) {
            return false;
        }

        return ! array_is_list($decoded);
    }

    protected function resolveErrorPayload(string $source, int $id): ?array
    {
        if ($source === 'cached') {
            $record = CachedTest::find($id);
            return $record ? $this->payload('Cached Test Error', $record->projectUrl, [
                'result' => $record->result,
                'resultsData' => $record->resultsData,
                'dataFailed' => $record->dataFailed,
                'dataPassed' => $record->dataPassed,
            ], $record->created_at) : null;
        }

        if ($source === 'test-result') {
            $record = TestResults::find($id);
            return $record ? $this->payload('Website Test Error', $record->url, $this->decode($record->data), $record->created_at) : null;
        }

        if ($source === 'dashboard-run') {
            $run = DashboardTests::with('dashboardTestsDetails')->find($id);
            if (! $run) {
                return null;
            }

            $failed = $run->dashboardTestsDetails
                ->filter(function (DashboardTestsDetails $detail) {
                    return $detail->status === 'failed' || (bool) $detail->error_message;
                })
                ->map(function (DashboardTestsDetails $detail) {
                    return [
                        'url' => $detail->url,
                        'status' => $detail->status,
                        'error_message' => $detail->error_message,
                    ];
                })->values()->all();

            return $this->payload('Full Website Re-check Errors', $run->status, [
                'run_status' => $run->status,
                'failed_checks' => $failed,
            ], $run->created_at);
        }

        if ($source === 'dashboard-detail') {
            $record = DashboardTestsDetails::find($id);
            return $record ? $this->payload('Dashboard Test Error', $record->url, [
                'status' => $record->status,
                'error_message' => $record->error_message,
                'data' => $this->decode($record->data),
            ], $record->created_at) : null;
        }

        if ($source === 'lighthouse-result') {
            $record = LighthouseResult::find($id);
            return $record ? $this->payload('Lighthouse Test Error', $record->url, [
                'status' => $record->status,
                'strategy' => $record->strategy,
                'error_message' => $record->error_message,
                'data' => $record->data,
            ], $record->created_at) : null;
        }

        if ($source === 'lighthouse-run') {
            $run = LighthouseTest::with('results')->find($id);
            if (! $run) {
                return null;
            }

            $failed = $run->results
                ->filter(function (LighthouseResult $result) {
                    return $result->status === 'failed' || (bool) $result->error_message;
                })
                ->map(function (LighthouseResult $result) {
                    return [
                        'url' => $result->url,
                        'strategy' => $result->strategy,
                        'status' => $result->status,
                        'error_message' => $result->error_message,
                    ];
                })->values()->all();

            $urls = LighthouseUrlParser::fromStoredJson($run->urls);

            return $this->payload('Page Speed Run Errors', count($urls) . ' URLs', [
                'run_status' => $run->status,
                'failed_checks' => $failed,
            ], $run->created_at);
        }

        return null;
    }

    protected function payload(string $title, ?string $url, $context, $date): array
    {
        return [
            'title' => $title,
            'testedUrl' => $url ?: 'Not captured',
            'date' => $date,
            'context' => $context,
        ];
    }

    protected function hasFailures($value): bool
    {
        $value = $this->decode($value);

        if ($value === false || $value === 'failed') {
            return true;
        }

        if (! is_array($value)) {
            return false;
        }

        foreach ($value as $key => $item) {
            if (in_array($key, ['status', 'passed', 'success'], true) && ($item === false || $item === 'failed')) {
                return true;
            }

            if ($this->hasFailures($item)) {
                return true;
            }
        }

        return false;
    }

    protected function summarizeContext($context): string
    {
        $encoded = json_encode($context, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        return Str::limit($encoded ?: 'Failure details captured.', 180);
    }

    protected function decode($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
        }

        return $value;
    }
}

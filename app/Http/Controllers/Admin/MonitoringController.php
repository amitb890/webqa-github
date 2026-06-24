<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CachedTest;
use App\Models\DashboardTestsDetails;
use App\Models\LighthouseResult;
use App\Models\TestResults;
use App\Models\User;
use App\Models\UserActionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MonitoringController extends Controller
{
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
                'source' => $test->web_app ? 'App analysis archive' : 'Website or bulk tool test',
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

            return [
                'date' => $test->created_at,
                'url' => $test->url,
                'type' => $test->project_id ? 'Webapp Analysis' : 'Webpage Analysis',
                'source' => $test->settings_mode ? Str::title(str_replace(['_', '-'], ' ', $test->settings_mode)) : 'Website test',
                'result' => $failed ? 'failed' : 'success',
                'cached_url' => url('analysis-report/w/' . $test->ref_id),
                'error_url' => $failed ? route('admin.tests.error', ['source' => 'test-result', 'id' => $test->id]) : null,
                'error_preview' => $failed ? $this->summarizeContext($data) : null,
            ];
        });
    }

    protected function dashboardTestRows(?string $date): Collection
    {
        $query = DashboardTestsDetails::with('dashboardTest')->latest();
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        return $query->limit(300)->get()->map(function (DashboardTestsDetails $detail) {
            $runStatus = optional($detail->dashboardTest)->status;
            $failed = $detail->status === 'failed' || (bool) $detail->error_message;

            return [
                'date' => $detail->created_at,
                'url' => $detail->url,
                'type' => in_array($runStatus, ['recheck', 'recheck-single'], true)
                    ? 'Webapp Analysis - Full Re-check'
                    : 'Webapp Analysis',
                'source' => 'Dashboard / Website Tracker',
                'result' => $failed ? 'failed' : ($detail->status === 'completed' ? 'success' : 'pending'),
                'cached_url' => null,
                'error_url' => $failed ? route('admin.tests.error', ['source' => 'dashboard-detail', 'id' => $detail->id]) : null,
                'error_preview' => $detail->error_message,
            ];
        });
    }

    protected function lighthouseRows(?string $date): Collection
    {
        $query = LighthouseResult::with('test')->latest();
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        return $query->limit(300)->get()->map(function (LighthouseResult $result) {
            $failed = $result->status === 'failed' || (bool) $result->error_message;

            return [
                'date' => $result->created_at,
                'url' => $result->url,
                'type' => 'Google PageSpeed Lighthouse',
                'source' => 'Dashboard / Recheck',
                'result' => $failed ? 'failed' : ($result->status === 'completed' ? 'success' : 'pending'),
                'cached_url' => null,
                'error_url' => $failed ? route('admin.tests.error', ['source' => 'lighthouse-result', 'id' => $result->id]) : null,
                'error_preview' => $result->error_message,
            ];
        });
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

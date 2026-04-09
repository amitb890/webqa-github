<?php

namespace App\Services;

use App\Models\DashboardTests;
use App\Models\DashboardTestsDetails;
use App\Models\LighthouseResult;
use App\Models\LighthouseTest;
use App\Models\projectSettings;
use App\Models\ProjectUiSnapshot;
use App\Models\Projects;
use Illuminate\Support\Facades\Log;

class ProjectUiSnapshotService
{
    /** Memory for aggregation + json_encode of large payloads (queue / lazy warm). */
    private static function raiseMemoryLimitForSnapshot(): ?string
    {
        $prev = ini_get('memory_limit');
        @ini_set('memory_limit', '512M');

        return $prev !== false ? (string) $prev : null;
    }

    private static function restoreMemoryLimit(?string $prev): void
    {
        if ($prev !== null && $prev !== '') {
            @ini_set('memory_limit', $prev);
        }
    }

    public static function invalidate(int $projectId): void
    {
        ProjectUiSnapshot::where('project_id', $projectId)->delete();
    }

    /**
     * Raw JSON body for GET get-test-data (no json_decode — avoids 2× memory on read).
     */
    public static function getCachedTestDataJson(int $projectId, DashboardTests $dashboardTest): ?string
    {
        if ($dashboardTest->status !== 'completed') {
            return null;
        }

        $snap = ProjectUiSnapshot::query()
            ->where('project_id', $projectId)
            ->select(['id', 'dashboard_test_id', 'cached_test_data_json'])
            ->first();

        if (! $snap || (int) $snap->dashboard_test_id !== (int) $dashboardTest->id) {
            return null;
        }

        $json = $snap->cached_test_data_json;
        if (! is_string($json) || $json === '') {
            return null;
        }

        return $json;
    }

    /**
     * Raw JSON for Lighthouse check-status payload when the run is finished.
     */
    public static function getCachedLighthouseJson(int $projectId, LighthouseTest $lighthouseTest): ?string
    {
        if ($lighthouseTest->status !== 'completed') {
            return null;
        }

        $snap = ProjectUiSnapshot::query()
            ->where('project_id', $projectId)
            ->select(['id', 'lighthouse_test_id', 'cached_lighthouse_json'])
            ->first();

        if (! $snap || (int) $snap->lighthouse_test_id !== (int) $lighthouseTest->id) {
            return null;
        }

        $json = $snap->cached_lighthouse_json;
        if (! is_string($json) || $json === '') {
            return null;
        }

        return $json;
    }

    /**
     * @param  iterable<int, \App\Models\DashboardTestsDetails>  $detailsIterable
     */
    public static function buildAggregatedResults(iterable $detailsIterable): array
    {
        $obj = [
            'meta_title' => [],
            'meta_desc' => [],
            'robots_meta' => [],
            'canonical_url' => [],
            'url_slug' => [],
            'meta_viewport' => [],
            'doctype' => [],
            'favicon' => [],
            'page_size' => [],
            'xml_sitemap' => [],
            'html_sitemap' => [],
            'images' => [],
            'open_graph_tags' => [],
            'twitter_tags' => [],
            'http_status_code' => [],
            'broken_links' => [],
            'robot_text_test' => [],
            'h1_heading_tag' => [],

            'security_labels' => [
                'is_safe_browsing' => [],
                'cross_origin_links' => [],
                'protocol_relative_resource' => [],
                'content_security_policy_header' => [],
                'x_frame_options_header' => [],
                'hsts_header' => [],
                'bad_content_type' => [],
                'ssl_certificate_enable' => [],
                'folder_browsing_enable' => [],
            ],

            'cbp_labels' => [
                'html_compression' => [],
                'css_compression' => [],
                'js_compression' => [],
                'gzip_compression' => [],
                'nested_tables' => [],
                'frameset' => [],
                'page_size' => [],
                'css_caching_enable' => [],
                'js_caching_enable' => [],
            ],

            'google_overall' => [],
            'google_lighthouse' => [],
            'core_web_vitals' => [],
            'mobile_friendly' => [],
        ];

        foreach ($detailsIterable as $detail) {
            if (! $detail->data) {
                continue;
            }

            $decoded = json_decode($detail->data, true);
            if (! is_array($decoded)) {
                continue;
            }

            foreach ($decoded as $testKey => $value) {
                if (isset($obj['security_labels'][$testKey])) {
                    $obj['security_labels'][$testKey][] = json_decode($value, true);
                    continue;
                }

                if (isset($obj['cbp_labels'][$testKey])) {
                    $obj['cbp_labels'][$testKey][] = json_decode($value, true);
                    continue;
                }

                if (isset($obj[$testKey])) {
                    $obj[$testKey][] = json_decode($value, true);
                    continue;
                }
            }
        }

        return $obj;
    }

    public static function buildTestDataPayload(int $projectId, Projects $project, DashboardTests $dashboardTest): array
    {
        $prevMem = self::raiseMemoryLimitForSnapshot();

        try {
            $settings = projectSettings::where('projects_id', $project->id)
                ->with('settingsSub')
                ->orderBy('id', 'DESC')
                ->get()
                ->first();

            $cursor = DashboardTestsDetails::query()
                ->where('dashboard_test_id', $dashboardTest->id)
                ->orderBy('id')
                ->cursor();

            $results = self::buildAggregatedResults($cursor);

            return [
                'status' => 1,
                'msg' => 'Success.',
                'project' => $project->toArray(),
                'dashboard_status' => $dashboardTest->status,
                'results' => $results,
                'settings' => $settings ? $settings->toArray() : null,
            ];
        } finally {
            self::restoreMemoryLimit($prevMem);
        }
    }

    /**
     * Same structure as LighthouseController::checkStatus JSON (status + results).
     */
    public static function buildLighthouseStatusPayload(?LighthouseTest $lighthouseTest): array
    {
        if (! $lighthouseTest) {
            return [
                'status' => 'in_progress',
                'results' => [],
            ];
        }

        $detailsTotal = LighthouseResult::where('test_id', $lighthouseTest->id)->get();

        $details = LighthouseResult::where('test_id', $lighthouseTest->id)
            ->whereIn('status', ['completed', 'failed'])
            ->get();

        $completedCount = 0;
        foreach ($details as $detail) {
            if (in_array($detail->status, ['completed', 'failed'], true)) {
                $completedCount++;
            }
        }

        $status = 'in_progress';
        if ($details->count() > 0 && $completedCount === $detailsTotal->count()) {
            $status = 'completed';
        }

        return [
            'status' => $status,
            'results' => $details->map(fn ($m) => $m->toArray())->values()->all(),
        ];
    }

    /**
     * Full snapshot after dashboard tests finish (expensive aggregation once).
     */
    public static function warmAfterDashboardComplete(int $projectId): void
    {
        $project = Projects::find($projectId);
        if (! $project) {
            return;
        }

        $dashboardTest = DashboardTests::where('project_id', $projectId)->latest()->first();
        if (! $dashboardTest || $dashboardTest->status !== 'completed') {
            return;
        }

        $prevMem = self::raiseMemoryLimitForSnapshot();

        try {
            $testData = self::buildTestDataPayload($projectId, $project, $dashboardTest);
            $testJson = json_encode($testData);
            unset($testData);

            $lighthouseTest = LighthouseTest::where('project_id', $projectId)->latest()->first();
            $lighthouse = self::buildLighthouseStatusPayload($lighthouseTest);
            $lhJson = json_encode($lighthouse);
            unset($lighthouse);

            if ($testJson === false || $lhJson === false) {
                Log::warning('ProjectUiSnapshotService::warmAfterDashboardComplete json_encode failed');

                return;
            }

            self::upsertSplitJson(
                $projectId,
                (int) $dashboardTest->id,
                $lighthouseTest ? (int) $lighthouseTest->id : null,
                $testJson,
                $lhJson
            );
        } catch (\Throwable $e) {
            Log::warning('ProjectUiSnapshotService::warmAfterDashboardComplete failed: '.$e->getMessage());
        } finally {
            self::restoreMemoryLimit($prevMem);
        }
    }

    /**
     * Update only Lighthouse JSON when PageSpeed jobs finish (no full payload decode).
     */
    public static function patchLighthouseAfterComplete(int $projectId): void
    {
        $snap = ProjectUiSnapshot::query()
            ->where('project_id', $projectId)
            ->select(['id', 'dashboard_test_id'])
            ->first();

        if (! $snap) {
            return;
        }

        $dashboardTest = DashboardTests::where('project_id', $projectId)->latest()->first();
        if (! $dashboardTest || $dashboardTest->status !== 'completed') {
            return;
        }

        if ((int) $snap->dashboard_test_id !== (int) $dashboardTest->id) {
            return;
        }

        $prevMem = self::raiseMemoryLimitForSnapshot();

        try {
            $lighthouseTest = LighthouseTest::where('project_id', $projectId)->latest()->first();
            if (! $lighthouseTest) {
                return;
            }

            $lighthouse = self::buildLighthouseStatusPayload($lighthouseTest);
            $lhJson = json_encode($lighthouse);
            unset($lighthouse);

            if ($lhJson === false) {
                return;
            }

            ProjectUiSnapshot::where('project_id', $projectId)->update([
                'lighthouse_test_id' => $lighthouseTest->id,
                'cached_lighthouse_json' => $lhJson,
            ]);
        } catch (\Throwable $e) {
            Log::warning('ProjectUiSnapshotService::patchLighthouseAfterComplete failed: '.$e->getMessage());
        } finally {
            self::restoreMemoryLimit($prevMem);
        }
    }

    /**
     * Lazy fill when queue warm failed or cache was cleared.
     */
    public static function ensureSnapshotForCompletedDashboard(int $projectId): void
    {
        $dashboardTest = DashboardTests::where('project_id', $projectId)->latest()->first();
        if (! $dashboardTest || $dashboardTest->status !== 'completed') {
            return;
        }

        $existing = ProjectUiSnapshot::query()
            ->where('project_id', $projectId)
            ->select(['dashboard_test_id', 'cached_test_data_json'])
            ->first();

        if (
            $existing
            && (int) $existing->dashboard_test_id === (int) $dashboardTest->id
            && is_string($existing->cached_test_data_json)
            && strlen($existing->cached_test_data_json) > 2
        ) {
            return;
        }

        self::warmAfterDashboardComplete($projectId);
    }

    private static function upsertSplitJson(
        int $projectId,
        int $dashboardTestId,
        ?int $lighthouseTestId,
        string $testDataJson,
        string $lighthouseJson
    ): void {
        ProjectUiSnapshot::updateOrCreate(
            ['project_id' => $projectId],
            [
                'dashboard_test_id' => $dashboardTestId,
                'lighthouse_test_id' => $lighthouseTestId,
                'cached_test_data_json' => $testDataJson,
                'cached_lighthouse_json' => $lighthouseJson,
                'payload' => null,
            ]
        );
    }
}

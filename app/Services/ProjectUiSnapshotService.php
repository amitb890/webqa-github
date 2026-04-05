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
    public static function invalidate(int $projectId): void
    {
        ProjectUiSnapshot::where('project_id', $projectId)->delete();
    }

    /**
     * Cached get-test-data payload (same shape as ProjectsController::getTestData JSON).
     */
    public static function getCachedTestData(int $projectId, DashboardTests $dashboardTest): ?array
    {
        if ($dashboardTest->status !== 'completed') {
            return null;
        }

        $snap = ProjectUiSnapshot::where('project_id', $projectId)->first();
        if (!$snap || (int) $snap->dashboard_test_id !== (int) $dashboardTest->id) {
            return null;
        }

        $payload = json_decode($snap->payload, true);
        if (!is_array($payload) || empty($payload['test_data']) || !is_array($payload['test_data'])) {
            return null;
        }

        $out = $payload['test_data'];
        $out['dashboard_status'] = $dashboardTest->status;

        return $out;
    }

    /**
     * Cached Lighthouse check-status payload when the run is finished.
     */
    public static function getCachedLighthouseStatus(int $projectId, LighthouseTest $lighthouseTest): ?array
    {
        if ($lighthouseTest->status !== 'completed') {
            return null;
        }

        $snap = ProjectUiSnapshot::where('project_id', $projectId)->first();
        if (!$snap || (int) $snap->lighthouse_test_id !== (int) $lighthouseTest->id) {
            return null;
        }

        $payload = json_decode($snap->payload, true);
        if (!is_array($payload) || empty($payload['lighthouse']) || !is_array($payload['lighthouse'])) {
            return null;
        }

        return $payload['lighthouse'];
    }

    public static function buildAggregatedResults($details): array
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

        foreach ($details as $detail) {
            if (!$detail->data) {
                continue;
            }

            $decoded = json_decode($detail->data, true);
            if (!is_array($decoded)) {
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
        $settings = projectSettings::where('projects_id', $project->id)
            ->with('settingsSub')
            ->orderBy('id', 'DESC')
            ->get()
            ->first();

        $details = DashboardTestsDetails::where('dashboard_test_id', $dashboardTest->id)->get();
        $results = self::buildAggregatedResults($details);

        return [
            'status' => 1,
            'msg' => 'Success.',
            'project' => $project->toArray(),
            'dashboard_status' => $dashboardTest->status,
            'results' => $results,
            'settings' => $settings ? $settings->toArray() : null,
        ];
    }

    /**
     * Same structure as LighthouseController::checkStatus JSON (status + results).
     */
    public static function buildLighthouseStatusPayload(?LighthouseTest $lighthouseTest): array
    {
        if (!$lighthouseTest) {
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
        if (!$project) {
            return;
        }

        $dashboardTest = DashboardTests::where('project_id', $projectId)->latest()->first();
        if (!$dashboardTest || $dashboardTest->status !== 'completed') {
            return;
        }

        try {
            $testData = self::buildTestDataPayload($projectId, $project, $dashboardTest);
            $lighthouseTest = LighthouseTest::where('project_id', $projectId)->latest()->first();
            $lighthouse = self::buildLighthouseStatusPayload($lighthouseTest);

            self::upsertPayload(
                $projectId,
                (int) $dashboardTest->id,
                $lighthouseTest ? (int) $lighthouseTest->id : null,
                [
                    'test_data' => $testData,
                    'lighthouse' => $lighthouse,
                ]
            );
        } catch (\Throwable $e) {
            Log::warning('ProjectUiSnapshotService::warmAfterDashboardComplete failed: '.$e->getMessage());
        }
    }

    /**
     * Update only Lighthouse portion when PageSpeed jobs finish (cheap).
     */
    public static function patchLighthouseAfterComplete(int $projectId): void
    {
        $snap = ProjectUiSnapshot::where('project_id', $projectId)->first();
        if (!$snap) {
            return;
        }

        $dashboardTest = DashboardTests::where('project_id', $projectId)->latest()->first();
        if (!$dashboardTest || $dashboardTest->status !== 'completed') {
            return;
        }

        if ((int) $snap->dashboard_test_id !== (int) $dashboardTest->id) {
            return;
        }

        try {
            $lighthouseTest = LighthouseTest::where('project_id', $projectId)->latest()->first();
            if (!$lighthouseTest) {
                return;
            }

            $lighthouse = self::buildLighthouseStatusPayload($lighthouseTest);
            $payload = json_decode($snap->payload, true);
            if (!is_array($payload)) {
                $payload = [];
            }
            $payload['lighthouse'] = $lighthouse;

            $snap->lighthouse_test_id = $lighthouseTest->id;
            $snap->payload = json_encode($payload);
            $snap->save();
        } catch (\Throwable $e) {
            Log::warning('ProjectUiSnapshotService::patchLighthouseAfterComplete failed: '.$e->getMessage());
        }
    }

    /**
     * Lazy fill when queue warm failed or cache was cleared.
     */
    public static function ensureSnapshotForCompletedDashboard(int $projectId): void
    {
        $dashboardTest = DashboardTests::where('project_id', $projectId)->latest()->first();
        if (!$dashboardTest || $dashboardTest->status !== 'completed') {
            return;
        }

        $existing = ProjectUiSnapshot::where('project_id', $projectId)->first();
        if ($existing && (int) $existing->dashboard_test_id === (int) $dashboardTest->id) {
            $decoded = json_decode($existing->payload, true);
            if (is_array($decoded) && ! empty($decoded['test_data']) && is_array($decoded['test_data'])) {
                return;
            }
        }

        self::warmAfterDashboardComplete($projectId);
    }

    private static function upsertPayload(int $projectId, int $dashboardTestId, ?int $lighthouseTestId, array $body): void
    {
        ProjectUiSnapshot::updateOrCreate(
            ['project_id' => $projectId],
            [
                'dashboard_test_id' => $dashboardTestId,
                'lighthouse_test_id' => $lighthouseTestId,
                'payload' => json_encode($body),
            ]
        );
    }
}

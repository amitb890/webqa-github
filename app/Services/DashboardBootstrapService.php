<?php

namespace App\Services;

use App\Models\Alerts;
use App\Models\CachedDashboardDetail;
use App\Models\DashboardTests;
use App\Models\LighthouseTest;
use App\Models\Projects;
use App\Models\projectSettings;
use App\Models\UrlsList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardBootstrapService
{
    public static function resolveActiveProjectId(): ?int
    {
        $userId = Auth::id();
        if (!$userId) {
            return null;
        }

        $projectId = null;

        if (isset($_COOKIE['activeProject']) && $_COOKIE['activeProject'] !== '') {
            $cookieValue = (string) $_COOKIE['activeProject'];
            if (str_contains($cookieValue, '-')) {
                $parts = explode('-', $cookieValue);
                $projectId = (int) end($parts);
            } else {
                $projectId = (int) $cookieValue;
            }
        }

        if ($projectId) {
            $project = Projects::where('id', $projectId)
                ->where('user_id', $userId)
                ->first();
            if ($project) {
                return (int) $project->id;
            }
        }

        if (session()->has('active_project_id')) {
            $sessionProject = Projects::where('id', (int) session('active_project_id'))
                ->where('user_id', $userId)
                ->first();
            if ($sessionProject) {
                return (int) $sessionProject->id;
            }
        }

        $fallback = Projects::where('user_id', $userId)
            ->orderByDesc('id')
            ->first();

        return $fallback ? (int) $fallback->id : null;
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function buildForProject(int $projectId): ?array
    {
        $userId = Auth::id();
        if (!$userId) {
            return null;
        }

        $project = Projects::where('id', $projectId)
            ->where('user_id', $userId)
            ->first();

        if (!$project) {
            return null;
        }

        $labels = DashboardLabelsService::groupedLabelsForProject($projectId);
        $urls = UrlsList::where('projects_id', $projectId)->get()->values()->all();
        $dashboardState = self::dashboardShowState($project);
        $testsRunning = self::testsAppearRunning($projectId);

        $bootstrap = [
            'projectId' => $projectId,
            'dashboardStatus' => $dashboardState['dashboardStatus'],
            'details_progress' => $dashboardState['details_progress'],
            'dashboard_fully_tested' => (int) ($project->dashboard_fully_tested ?? 0),
            'testsRunning' => $testsRunning,
            'labels' => self::serializeLabels($labels),
            'urls' => $urls,
            'testData' => null,
        ];

        if (in_array($dashboardState['dashboardStatus'], [1, 3], true)) {
            $cachedTestData = self::buildCachedTestDataIfReady($projectId, $project);
            if ($cachedTestData !== null) {
                $bootstrap['testData'] = $cachedTestData;
            }
        }

        return $bootstrap;
    }

    /**
     * @return array{dashboardStatus: int, details_progress: string}
     */
    public static function dashboardShowState(Projects $project): array
    {
        $details = DashboardTests::where('project_id', $project->id)
            ->latest()
            ->first();

        $detailsStatus = $details->status ?? 'pending';
        $dashboardStatus = 0;

        if ($detailsStatus === 'completed' && $project->dashboard_show_status) {
            $dashboardStatus = 1;
        }

        if ($detailsStatus === 'recheck') {
            $dashboardStatus = 2;
        }

        if ($detailsStatus === 'recheck-single') {
            $dashboardStatus = 3;
        }

        return [
            'dashboardStatus' => $dashboardStatus,
            'details_progress' => $detailsStatus,
        ];
    }

    public static function testsAppearRunning(int $projectId): bool
    {
        $dashboardTest = DashboardTests::where('project_id', $projectId)->latest()->first();
        if ($dashboardTest && in_array($dashboardTest->status, ['pending', 'in_progress'], true)) {
            return true;
        }

        $lighthouseTest = LighthouseTest::where('project_id', $projectId)->latest()->first();
        if ($lighthouseTest && $lighthouseTest->status === 'in_progress') {
            return true;
        }

        return false;
    }

    /**
     * Cached dashboard payload (same shape as GET /get-test-data when use_cached_dashboard).
     *
     * @return array<string, mixed>|null
     */
    public static function buildCachedTestDataIfReady(int $projectId, Projects $project): ?array
    {
        if (
            !DashboardTrackerCacheService::hasProjectDashboardFullyTestedColumn()
            || (int) $project->dashboard_fully_tested !== 1
            || !Schema::hasTable('cached_dashboard_details')
        ) {
            return null;
        }

        $dashboardTest = DashboardTests::where('project_id', $projectId)->latest()->first();
        if (!$dashboardTest) {
            return null;
        }

        $settings = projectSettings::where('projects_id', $project->id)
            ->with('settingsSub')
            ->orderByDesc('id')
            ->first();

        $cachedRows = CachedDashboardDetail::query()
            ->where('project_id', $projectId)
            ->where('user_id', (int) $project->user_id)
            ->orderBy('id')
            ->get(['widget_key', 'widget_data_json']);

        $results = [];
        foreach ($cachedRows as $row) {
            $decoded = json_decode((string) $row->widget_data_json, true);
            $results[$row->widget_key] = is_array($decoded) ? $decoded : [];
        }

        foreach (['google_overall', 'google_lighthouse', 'core_web_vitals'] as $googleKey) {
            unset($results[$googleKey]);
        }

        $alerts = Alerts::where('user_id', Auth::id())
            ->where('project_id', $projectId)
            ->where('page', 'dashboard')
            ->where('status', 1)
            ->get();

        return [
            'status' => 1,
            'msg' => 'Success.',
            'project' => $project->toArray(),
            'dashboard_status' => $dashboardTest->status,
            'results' => $results,
            'settings' => $settings ? $settings->toArray() : null,
            'use_cached_dashboard' => true,
            'alerts' => $alerts->toArray(),
        ];
    }

    /**
     * @param  array{all_labels: array, seo_labels: array, performance_labels: array, cbp_labels: array, security_labels: array}  $labels
     * @return array<string, array<int, array<string, mixed>>>
     */
    private static function serializeLabels(array $labels): array
    {
        $out = [];
        foreach ($labels as $key => $collection) {
            $out[$key] = collect($collection)->map(function ($label) {
                return is_object($label) && method_exists($label, 'toArray')
                    ? $label->toArray()
                    : (array) $label;
            })->values()->all();
        }

        return $out;
    }
}

<?php

namespace App\Services;

use App\Http\Controllers\TestDetailsController;
use App\Models\DashboardTests;
use App\Models\DashboardTestsDetails;
use App\Models\LighthouseResult;
use App\Models\LighthouseTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardTrackerCacheService
{
    /** Not exposed as tests in the app; keep out of cache tables. */
    private const OMITTED_CACHE_WIDGET_KEYS = [
        'url_slug',
        'meta_viewport',
        'doctype',
        'favicon',
        'page_size',
    ];

    private const DASHBOARD_WIDGET_KEYS = [
        'meta_title',
        'meta_desc',
        'robots_meta',
        'canonical_url',
        'xml_sitemap',
        'html_sitemap',
        'images',
        'open_graph_tags',
        'twitter_tags',
        'http_status_code',
        'broken_links',
        'robot_text_test',
        'h1_heading_tag',
        'security_labels',
        'cbp_labels',
        'google_overall',
        'google_lighthouse',
        'core_web_vitals',
        'mobile_friendly',
    ];

    private const TRACKER_WIDGET_KEYS = [
        'meta_title',
        'meta_desc',
        'robots_meta',
        'canonical_url',
        'http_status_code',
        'xml_sitemap',
        'html_sitemap',
        'images',
        'broken_links',
        'robot_text_test',
        'h1_heading_tag',
        'open_graph_tags',
        'twitter_tags',
        'is_safe_browsing',
        'cross_origin_links',
        'protocol_relative_resource',
        'content_security_policy_header',
        'x_frame_options_header',
        'hsts_header',
        'bad_content_type',
        'ssl_certificate_enable',
        'folder_browsing_enable',
        'html_compression',
        'css_compression',
        'js_compression',
        'gzip_compression',
        'nested_tables',
        'frameset',
        'css_caching_enable',
        'js_caching_enable',
        'google_overall',
        'google_lighthouse',
        'core_web_vitals',
        'mobile_friendly',
    ];

    public static function initializeProjectCaches(int $projectId, int $userId): void
    {
        if (! Schema::hasTable('cached_dashboard_details') || ! Schema::hasTable('cached_tracker_details')) {
            return;
        }

        $now = now();
        $dashboardRows = [];
        foreach (self::DASHBOARD_WIDGET_KEYS as $widgetKey) {
            $dashboardRows[] = [
                'project_id' => $projectId,
                'user_id' => $userId,
                'widget_key' => $widgetKey,
                'widget_data_json' => json_encode(new \stdClass()),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('cached_dashboard_details')->upsert(
            $dashboardRows,
            ['project_id', 'user_id', 'widget_key'],
            ['widget_data_json', 'updated_at']
        );

        self::deleteOmittedWidgetCacheRows($projectId, $userId);
    }

    public static function markProjectDashboardFullyTested(int $projectId): void
    {
        if (! Schema::hasTable('projects') || ! Schema::hasColumn('projects', 'dashboard_fully_tested')) {
            return;
        }

        DB::table('projects')
            ->where('id', $projectId)
            ->update(['dashboard_fully_tested' => 1]);
    }

    public static function resetProjectDashboardFullyTested(int $projectId): void
    {
        if (! Schema::hasTable('projects') || ! Schema::hasColumn('projects', 'dashboard_fully_tested')) {
            return;
        }

        DB::table('projects')
            ->where('id', $projectId)
            ->update(['dashboard_fully_tested' => 0]);
    }

    public static function hasProjectDashboardFullyTestedColumn(): bool
    {
        return Schema::hasTable('projects') && Schema::hasColumn('projects', 'dashboard_fully_tested');
    }

    public static function getProjectDashboardFullyTestedValue(int $projectId): int
    {
        if (! self::hasProjectDashboardFullyTestedColumn()) {
            return 0;
        }

        return (int) DB::table('projects')->where('id', $projectId)->value('dashboard_fully_tested');
    }

    public static function canUseCacheTables(): bool
    {
        return Schema::hasTable('cached_dashboard_details') && Schema::hasTable('cached_tracker_details');
    }

    public static function finalizeDashboardTestAndRefreshCaches(
        int $projectId,
        int $userId,
        int $dashboardTestId,
        string $testType = 'default',
        ?string $recheckLabel = null
    ): void
    {
        self::markProjectDashboardFullyTested($projectId);

        if (! self::canUseCacheTables()) {
            return;
        }

        DB::transaction(function () use ($projectId, $userId, $dashboardTestId, $testType, $recheckLabel) {
            $dashboardTest = DashboardTests::find($dashboardTestId);
            $targetUrls = self::extractRunTargetUrls($dashboardTest);

            $details = DashboardTestsDetails::where('dashboard_test_id', $dashboardTestId)
                ->whereNotNull('data')
                ->when(! empty($targetUrls), function ($query) use ($targetUrls) {
                    $query->whereIn('url', $targetUrls);
                })
                ->get(['url', 'data']);

            $aggregated = DashboardTestDataService::buildAggregatedResults($details);
            $now = now();
            $dashboardKeysToUpdate = self::resolveDashboardWidgetKeysToUpdate($testType, $recheckLabel);
            $dashboardRows = [];
            foreach ($dashboardKeysToUpdate as $widgetKey) {
                $dashboardRows[] = [
                    'project_id' => $projectId,
                    'user_id' => $userId,
                    'widget_key' => $widgetKey,
                    'widget_data_json' => json_encode(
                        self::buildDashboardCardSummary($widgetKey, $aggregated[$widgetKey] ?? [])
                    ),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('cached_dashboard_details')->upsert(
                $dashboardRows,
                ['project_id', 'user_id', 'widget_key'],
                ['widget_data_json', 'updated_at']
            );

            $trackerRows = [];
            foreach ($details as $detail) {
                $decoded = json_decode((string) $detail->data, true);
                if (! is_array($decoded)) {
                    continue;
                }

                $trackerData = self::extractTrackerDataFromSingleUrlResult($decoded);
                foreach (self::TRACKER_WIDGET_KEYS as $widgetKey) {
                    $trackerRows[] = [
                        'project_id' => $projectId,
                        'user_id' => $userId,
                        'url' => (string) $detail->url,
                        'widget_key' => $widgetKey,
                        'widget_data_json' => json_encode($trackerData[$widgetKey] ?? []),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            foreach (array_chunk($trackerRows, 500) as $rowsChunk) {
                DB::table('cached_tracker_details')->upsert(
                    $rowsChunk,
                    ['project_id', 'user_id', 'url', 'widget_key'],
                    ['widget_data_json', 'updated_at']
                );
            }

            self::deleteOmittedWidgetCacheRows($projectId, $userId);
        });
    }

    public static function finalizeGoogleWidgetsCache(int $projectId, int $userId, int $lighthouseTestId): void
    {
        if (! self::canUseCacheTables()) {
            return;
        }

        $test = LighthouseTest::find($lighthouseTestId);
        if (! $test) {
            return;
        }

        $rows = LighthouseResult::where('test_id', $lighthouseTestId)->get()->toArray();
        $now = now();
        $widgetToFormatter = [
            'google_overall' => 'googleInsights',
            'google_lighthouse' => 'googleLighthouse',
            'core_web_vitals' => 'googleCoreWebVitals',
        ];

        $cacheRows = [];
        foreach ($widgetToFormatter as $widgetKey => $formatter) {
            $summary = self::invokeDashboardFormatter($formatter, $rows);
            $cacheRows[] = [
                'project_id' => $projectId,
                'user_id' => $userId,
                'widget_key' => $widgetKey,
                'widget_data_json' => json_encode(self::sanitizeDashboardSummary($widgetKey, $summary)),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('cached_dashboard_details')->upsert(
            $cacheRows,
            ['project_id', 'user_id', 'widget_key'],
            ['widget_data_json', 'updated_at']
        );
    }

    private static function extractRunTargetUrls(?DashboardTests $dashboardTest): array
    {
        if (! $dashboardTest || ! is_string($dashboardTest->urls) || trim($dashboardTest->urls) === '') {
            return [];
        }

        $decoded = json_decode($dashboardTest->urls, true);
        if (! is_array($decoded)) {
            return [];
        }

        $urls = [];
        foreach ($decoded as $item) {
            if (is_array($item) && isset($item['url']) && is_string($item['url']) && trim($item['url']) !== '') {
                $urls[] = trim($item['url']);
                continue;
            }

            if (is_string($item) && trim($item) !== '') {
                $urls[] = trim($item);
            }
        }

        return array_values(array_unique($urls));
    }

    private static function extractTrackerDataFromSingleUrlResult(array $decoded): array
    {
        $result = [];
        foreach (self::TRACKER_WIDGET_KEYS as $key) {
            $result[$key] = [];
        }

        foreach ($decoded as $testKey => $value) {
            $decodedValue = json_decode((string) $value, true);
            if ($decodedValue === null && json_last_error() !== JSON_ERROR_NONE) {
                $decodedValue = $value;
            }

            if (array_key_exists($testKey, $result)) {
                $result[$testKey] = $decodedValue;
            }
        }

        // Flatten grouped widgets used by tracker.js into their concrete keys.
        $securityKeys = [
            'is_safe_browsing',
            'cross_origin_links',
            'protocol_relative_resource',
            'content_security_policy_header',
            'x_frame_options_header',
            'hsts_header',
            'bad_content_type',
            'ssl_certificate_enable',
            'folder_browsing_enable',
        ];

        foreach ($securityKeys as $securityKey) {
            if (isset($decoded[$securityKey])) {
                $result[$securityKey] = json_decode((string) $decoded[$securityKey], true);
            }
        }

        $cbpKeys = [
            'html_compression',
            'css_compression',
            'js_compression',
            'gzip_compression',
            'nested_tables',
            'frameset',
            'css_caching_enable',
            'js_caching_enable',
        ];

        foreach ($cbpKeys as $cbpKey) {
            if (isset($decoded[$cbpKey])) {
                $result[$cbpKey] = json_decode((string) $decoded[$cbpKey], true);
            }
        }

        return $result;
    }

    private static function buildDashboardCardSummary(string $widgetKey, mixed $widgetData): array
    {
        if (! is_array($widgetData)) {
            return self::compactPrimitiveWidgetSummary($widgetData);
        }

        $formatterMap = [
            'meta_title' => 'title',
            'meta_desc' => 'description',
            'robots_meta' => 'robots',
            'canonical_url' => 'canonical',
            'xml_sitemap' => 'xmlSitemap',
            'html_sitemap' => 'htmlSitemap',
            'images' => 'images',
            'open_graph_tags' => 'ogTags',
            'twitter_tags' => 'twitterTags',
            'http_status_code' => 'httpStatusCode',
            'broken_links' => 'brokenLinks',
            'robot_text_test' => 'robotTextTest',
            'h1_heading_tag' => 'headings',
            'security_labels' => 'securityHeaders',
            'cbp_labels' => 'codingBestPractices',
            'mobile_friendly' => 'mobileFriendly',
            'google_overall' => 'googleInsights',
            'google_lighthouse' => 'googleLighthouse',
            'core_web_vitals' => 'googleCoreWebVitals',
        ];

        if (isset($formatterMap[$widgetKey])) {
            $summary = self::invokeDashboardFormatter($formatterMap[$widgetKey], $widgetData);
            if (! empty($summary)) {
                return self::sanitizeDashboardSummary($widgetKey, $summary);
            }
        }

        // For widgets without dedicated dashboard card formatter methods, keep lightweight.
        return ['total_items' => count($widgetData)];
    }

    private static function compactPrimitiveWidgetSummary(mixed $widgetData): array
    {
        if (is_array($widgetData)) {
            return ['total_items' => count($widgetData)];
        }

        if (is_object($widgetData)) {
            return (array) $widgetData;
        }

        if ($widgetData === null) {
            return [];
        }

        return ['value' => $widgetData];
    }

    private static function toArray(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_object($value)) {
            return (array) $value;
        }

        return [];
    }

    private static function invokeDashboardFormatter(string $methodName, array $widgetData): array
    {
        try {
            $controller = app(TestDetailsController::class);
            $request = Request::create('/', 'POST', [
                'data' => json_encode($widgetData),
            ]);

            ob_start();
            $response = $controller->{$methodName}($request);
            $echoOutput = (string) ob_get_clean();
            $responseOutput = (is_object($response) && method_exists($response, 'getContent'))
                ? (string) $response->getContent()
                : '';

            $json = trim($echoOutput !== '' ? $echoOutput : $responseOutput);
            if ($json === '') {
                return [];
            }

            $decoded = json_decode($json, true);
            return is_array($decoded) ? $decoded : [];
        } catch (\Throwable) {
            return [];
        }
    }

    private static function sanitizeDashboardSummary(string $widgetKey, array $summary): array
    {
        // These keys are UI/runtime metadata, not widget metrics.
        unset($summary['settings'], $summary['label']);

        // Keep only dashboard-card counts for these widgets.
        if ($widgetKey === 'http_status_code') {
            return self::pickKeys($summary, [
                'http200',
                'http100x',
                'http200x',
                'http300x',
                'http400x',
                'http500x',
            ]);
        }

        if ($widgetKey === 'broken_links') {
            return self::pickKeys($summary, [
                'totalBrokenLinks',
                'totalBrokenWebPages',
                'totalBrokenInternal',
                'totalBrokenExternal',
                'totalUrls',
            ]);
        }

        if ($widgetKey === 'robot_text_test') {
            return self::pickKeys($summary, [
                'robotsTxtUrl',
                'urlsBlockedThroughRobots',
                'resourcesBlockedThroughRobots',
                'totalUrls',
            ]);
        }

        if ($widgetKey === 'h1_heading_tag') {
            return self::pickKeys($summary, [
                'urlsPassed',
                'urlsFailed',
                'urlsMissingH1',
                'totalUrls',
            ]);
        }

        return $summary;
    }

    private static function resolveDashboardWidgetKeysToUpdate(string $testType, ?string $recheckLabel): array
    {
        if ($testType !== 'single_recheck') {
            return self::DASHBOARD_WIDGET_KEYS;
        }

        $label = trim((string) $recheckLabel);
        if ($label === 'security_labels') {
            return ['security_labels'];
        }
        if ($label === 'cbp_labels') {
            return ['cbp_labels'];
        }
        if ($label !== '' && in_array($label, self::DASHBOARD_WIDGET_KEYS, true)) {
            return [$label];
        }

        return self::DASHBOARD_WIDGET_KEYS;
    }

    private static function pickKeys(array $source, array $keys): array
    {
        $out = [];
        foreach ($keys as $key) {
            if (array_key_exists($key, $source)) {
                $out[$key] = $source[$key];
            }
        }

        return $out;
    }

    private static function deleteOmittedWidgetCacheRows(int $projectId, int $userId): void
    {
        if (! self::canUseCacheTables()) {
            return;
        }

        DB::table('cached_dashboard_details')
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->whereIn('widget_key', self::OMITTED_CACHE_WIDGET_KEYS)
            ->delete();

        DB::table('cached_tracker_details')
            ->where('project_id', $projectId)
            ->where('user_id', $userId)
            ->whereIn('widget_key', self::OMITTED_CACHE_WIDGET_KEYS)
            ->delete();
    }
}

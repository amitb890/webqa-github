<?php

namespace App\Services;

use App\Http\Controllers\TestDetailsController;
use App\Models\CachedTrackerDetail;
use App\Models\DashboardTests;
use App\Models\DashboardTestsDetails;
use App\Models\LighthouseResult;
use App\Models\LighthouseTest;
use App\Models\Projects;
use App\Models\projectSettings;
use App\Models\UrlsList;
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

    /** @var list<string> */
    private const TRACKER_SECURITY_WIDGET_KEYS = [
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

    /** @var list<string> */
    private const TRACKER_CBP_WIDGET_KEYS = [
        'html_compression',
        'css_compression',
        'js_compression',
        'gzip_compression',
        'nested_tables',
        'frameset',
        'css_caching_enable',
        'js_caching_enable',
    ];

    /** @var list<string> */
    private const TRACKER_GOOGLE_WIDGET_KEYS = [
        'google_overall',
        'google_lighthouse',
        'core_web_vitals',
    ];

    /** RunTest fields never stored in cached_tracker_details.widget_data_json. */
    private const TRACKER_RUNTEST_BLOAT_KEYS = [
        'settings',
        'label',
        'title',
        'problems',
        'message',
        'description',
        'showContent',
        'tagStatus',
        'casingStatus',
        'learnMoreURL',
        'tagName',
        'parentCard',
        'parent',
        'display_name',
        'name',
        'urlDetails',
        'reportsUrl',
        'db_name',
        'url',
        'is_dashboard_status',
        'analysis_status',
        'bulk_status',
        'show_dashboard_status',
        'has_dashboard_parent',
        'dashboard_parent',
        'initialTestingState',
        'created_at',
        'updated_at',
        'tested_url',
    ];

    /** @var list<string> */
    private const TRACKER_PASS_FAIL_WIDGET_KEYS = [
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
        'mobile_friendly',
    ];

    /**
     * Build tracker API payload from cached_tracker_details (same shape as DashboardTestDataService::buildAggregatedResults).
     *
     * @return array<string, mixed>|null
     */
    public static function buildTrackerTestDataPayloadFromCache(
        int $projectId,
        Projects $project,
        DashboardTests $dashboardTest
    ): ?array {
        if (! self::canUseCacheTables()) {
            return null;
        }

        $settings = projectSettings::where('projects_id', $project->id)
            ->with('settingsSub')
            ->orderBy('id', 'DESC')
            ->first();

        $settingsSub = ($settings && $settings->settingsSub)
            ? $settings->settingsSub->toArray()
            : [];

        $urls = self::orderedTrackerUrls($dashboardTest->id, $projectId);
        if ($urls === []) {
            return null;
        }

        $cacheByUrl = [];
        $cacheRows = CachedTrackerDetail::query()
            ->where('project_id', $projectId)
            ->where('user_id', (int) $project->user_id)
            ->get(['url', 'widget_key', 'widget_data_json']);

        foreach ($cacheRows as $row) {
            $decoded = json_decode((string) $row->widget_data_json, true);
            $cacheByUrl[(string) $row->url][(string) $row->widget_key] = is_array($decoded) ? $decoded : [];
        }

        $results = self::emptyTrackerAggregatedResults();
        $legacyOnlyKeys = ['url_slug', 'meta_viewport', 'doctype', 'favicon', 'page_size'];

        foreach ($urls as $url) {
            $urlCells = $cacheByUrl[$url] ?? [];

            foreach (self::TRACKER_WIDGET_KEYS as $widgetKey) {
                if (in_array($widgetKey, self::TRACKER_GOOGLE_WIDGET_KEYS, true)) {
                    continue;
                }

                $cell = $urlCells[$widgetKey] ?? null;
                $slimCell = ($cell === null || $cell === [])
                    ? []
                    : self::sanitizeTrackerWidgetPayload($widgetKey, $cell);
                $payload = self::trackerAggregatedRowPayload(
                    $slimCell !== [] ? $slimCell : null,
                    $settingsSub,
                    $url
                );
                self::appendTrackerAggregatedRow($results, $widgetKey, $payload);
            }

            foreach ($legacyOnlyKeys as $legacyKey) {
                if (! isset($results[$legacyKey])) {
                    continue;
                }
                $results[$legacyKey][] = self::trackerAggregatedRowPayload(null, $settingsSub, $url);
            }
        }

        return [
            'status' => 1,
            'msg' => 'Success.',
            'project' => $project->toArray(),
            'dashboard_status' => $dashboardTest->status,
            'results' => $results,
            'settings' => $settings ? $settings->toArray() : null,
            'use_cached_tracker' => true,
        ];
    }

    /**
     * @return list<string>
     */
    private static function orderedTrackerUrls(int $dashboardTestId, int $projectId): array
    {
        $fromDetails = DashboardTestsDetails::query()
            ->where('dashboard_test_id', $dashboardTestId)
            ->orderBy('id')
            ->pluck('url')
            ->all();

        $seen = [];
        $urls = [];
        foreach ($fromDetails as $url) {
            $url = (string) $url;
            if ($url === '' || isset($seen[$url])) {
                continue;
            }
            $seen[$url] = true;
            $urls[] = $url;
        }

        if ($urls !== []) {
            return $urls;
        }

        return UrlsList::query()
            ->where('project_id', $projectId)
            ->orderBy('id')
            ->pluck('url')
            ->map(static function ($url) {
                return (string) $url;
            })
            ->filter(static function ($url) {
                return $url !== '';
            })
            ->values()
            ->all();
    }

    /**
     * @param  array<string, mixed>|null  $cell
     * @param  array<string, mixed>  $settingsSub
     * @return array<string, mixed>
     */
    private static function trackerAggregatedRowPayload(?array $cell, array $settingsSub, string $url): array
    {
        $base = [
            'settings' => $settingsSub,
            'tested_url' => $url,
        ];

        if ($cell === null) {
            return $base;
        }

        return array_merge($cell, $base);
    }

    /**
     * @param  array<string, mixed>  $obj
     * @param  array<string, mixed>  $payload
     */
    private static function appendTrackerAggregatedRow(array &$obj, string $widgetKey, array $payload): void
    {
        if (in_array($widgetKey, self::TRACKER_SECURITY_WIDGET_KEYS, true)) {
            $obj['security_labels'][$widgetKey][] = $payload;

            return;
        }

        if (in_array($widgetKey, self::TRACKER_CBP_WIDGET_KEYS, true)) {
            $obj['cbp_labels'][$widgetKey][] = $payload;

            return;
        }

        if (isset($obj[$widgetKey]) && is_array($obj[$widgetKey])) {
            $obj[$widgetKey][] = $payload;
        }
    }

    /**
     * Same top-level keys as DashboardTestDataService::buildAggregatedResults.
     *
     * @return array<string, mixed>
     */
    private static function emptyTrackerAggregatedResults(): array
    {
        return [
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
                        'widget_data_json' => json_encode(
                            self::sanitizeTrackerWidgetPayload(
                                $widgetKey,
                                $trackerData[$widgetKey] ?? []
                            )
                        ),
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

    /**
     * Minimal per-URL tracker cell payload (only fields used in tracker.js buildTableBody).
     *
     * @param  mixed  $raw
     */
    public static function sanitizeTrackerWidgetPayload(string $widgetKey, $raw): array
    {
        $row = self::decodeTrackerMixedToArray($raw);
        if ($row === []) {
            return [];
        }

        if (in_array($widgetKey, self::TRACKER_PASS_FAIL_WIDGET_KEYS, true)) {
            return self::finalizeTrackerPayload(self::trackerPassFailRow($row));
        }

        switch ($widgetKey) {
            case 'meta_title':
                $payload = self::trackerMetaTitleRow($row);
                break;
            case 'meta_desc':
                $payload = self::trackerMetaDescRow($row);
                break;
            case 'robots_meta':
                $payload = self::trackerRobotsRow($row);
                break;
            case 'canonical_url':
                $payload = self::trackerCanonicalRow($row);
                break;
            case 'http_status_code':
                $payload = self::trackerHttpStatusRow($row);
                break;
            case 'broken_links':
                $payload = self::trackerBrokenLinksRow($row);
                break;
            case 'robot_text_test':
                $payload = self::trackerRobotTextRow($row);
                break;
            case 'h1_heading_tag':
                $payload = self::trackerH1Row($row);
                break;
            case 'xml_sitemap':
            case 'html_sitemap':
                $payload = self::trackerSitemapRow($row, $widgetKey);
                break;
            case 'open_graph_tags':
                $payload = self::trackerOpenGraphRow($row);
                break;
            case 'twitter_tags':
                $payload = self::trackerTwitterRow($row);
                break;
            case 'images':
                $payload = self::trackerImagesRow($row);
                break;
            case 'google_overall':
                $payload = self::trackerGoogleOverallRow($row);
                break;
            case 'google_lighthouse':
                $payload = self::trackerGoogleLighthouseRow($row);
                break;
            case 'core_web_vitals':
                $payload = self::trackerCoreWebVitalsRow($row);
                break;
            default:
                $payload = self::trackerStatusOnlyRow($row);
                break;
        }

        return self::finalizeTrackerPayload($payload);
    }

    /**
     * @param  array<string, mixed>  $row
     * @param  list<string>  $keys
     * @return array<string, mixed>
     */
    private static function trackerCopyFields(array $row, array $keys): array
    {
        $out = [];
        foreach ($keys as $key) {
            if (array_key_exists($key, $row)) {
                $out[$key] = $row[$key];
            }
        }

        return $out;
    }

    /**
     * @param  array<string, mixed>  $row
     */
    private static function trackerResultClass(array $row, string $classKey, bool $passFallback): string
    {
        if (isset($row[$classKey]) && is_string($row[$classKey]) && $row[$classKey] !== '') {
            return $row[$classKey];
        }

        return $passFallback ? 'result_pass' : 'result_fail';
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerMetaTitleRow(array $row): array
    {
        $content = (string) ($row['content'] ?? '');
        $lengthPass = self::trackerLengthPassStatus($row, $content);

        $payload = self::trackerCopyFields($row, [
            'tested_at', 'content', 'lengthClass', 'casing', 'casingClass', 'status', 'testerrorcaught',
        ]);

        $payload['content'] = $content;
        $payload['length'] = self::trackerContentLength($content);
        $payload['lengthClass'] = self::trackerResultClass($row, 'lengthClass', $lengthPass);
        $payload['casing'] = (string) ($row['casing'] ?? '');
        $payload['casingClass'] = self::trackerResultClass(
            $row,
            'casingClass',
            self::trackerBool($row['casingStatus'] ?? $lengthPass)
        );
        $payload['equal_h1'] = self::trackerBool(
            $row['equal_h1'] ?? $row['equalH1'] ?? $row['isTitleEqualH1'] ?? false
        );
        $payload['status'] = self::trackerBool($row['status'] ?? $lengthPass);

        return $payload;
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerMetaDescRow(array $row): array
    {
        $content = (string) ($row['content'] ?? '');
        $lengthPass = self::trackerLengthPassStatus($row, $content);

        $payload = self::trackerCopyFields($row, [
            'tested_at', 'content', 'lengthClass', 'status', 'testerrorcaught',
        ]);
        $payload['content'] = $content;
        $payload['length'] = self::trackerContentLength($content);
        $payload['lengthClass'] = self::trackerResultClass($row, 'lengthClass', $lengthPass);
        $payload['status'] = self::trackerBool($row['status'] ?? $lengthPass);

        return $payload;
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerRobotsRow(array $row): array
    {
        return self::trackerCopyFields($row, [
            'tested_at', 'isExists', 'content', 'testerrorcaught',
        ]);
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerCanonicalRow(array $row): array
    {
        return self::trackerCopyFields($row, [
            'tested_at', 'content', 'statusIsEqualURL', 'status', 'testerrorcaught',
        ]);
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerHttpStatusRow(array $row): array
    {
        return self::trackerCopyFields($row, [
            'tested_at', 'httpCode', 'httpCodeName', 'status', 'testerrorcaught',
        ]);
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerBrokenLinksRow(array $row): array
    {
        return self::trackerCopyFields($row, [
            'tested_at',
            'status',
            'testerrorcaught',
            'status_url',
            'totalBrokenLinks',
            'totalBrokenInternal',
            'totalBrokenExternal',
            'totalBrokenWebPages',
        ]);
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerRobotTextRow(array $row): array
    {
        return self::trackerCopyFields($row, [
            'tested_at',
            'robots_txt_url',
            'tested_url',
            'urlBlock',
            'resources_blocked_count',
            'message',
            'testerrorcaught',
        ]);
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerH1Row(array $row): array
    {
        $payload = self::trackerCopyFields($row, [
            'tested_at', 'status', 'headingArray', 'testerrorcaught',
        ]);

        if (! isset($payload['headingArray']) || ! is_array($payload['headingArray'])) {
            return $payload;
        }

        $trimmed = [];
        foreach (['h1', 'h2', 'h3', 'h4', 'h5', 'h6'] as $tag) {
            if (isset($payload['headingArray'][$tag]) && is_array($payload['headingArray'][$tag])) {
                $trimmed[$tag] = $payload['headingArray'][$tag];
            }
        }
        $payload['headingArray'] = $trimmed;

        return $payload;
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerSitemapRow(array $row, string $widgetKey): array
    {
        $settings = self::decodeTrackerMixedToArray($row['settings'] ?? null);
        $valKey = $widgetKey === 'xml_sitemap' ? 'xml_sitemap_val' : 'html_sitemap_val';
        $url = (string) ($settings[$valKey] ?? '');
        $slimSettings = $url !== '' ? [$valKey => $url] : [];

        $payload = self::trackerCopyFields($row, [
            'tested_at', 'fileExists', 'status', 'message', 'testerrorcaught',
        ]);
        if ($slimSettings !== []) {
            $payload['settings'] = $slimSettings;
        }

        return $payload;
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerOpenGraphRow(array $row): array
    {
        $payload = self::trackerCopyFields($row, [
            'tested_at',
            'testerrorcaught',
            'status',
            'content',
            'lengthClass',
            'casing',
            'casingClass',
            'isEqualStatus',
            'isEqualClass',
            'contentDesc',
            'lengthDescClass',
            'isEqualDescStatus',
            'isEqualDescClass',
            'contentImage',
            'dimensions',
            'widthImageClass',
            'heightImageClass',
            'contentURL',
            'lengthURLClass',
            'isEqualURLStatus',
            'isEqualURLClass',
        ]);

        if (isset($payload['dimensions'])) {
            $payload['dimensions'] = self::sanitizeTrackerDimensionsOnlyWh($payload['dimensions']);
        }

        return $payload;
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerTwitterRow(array $row): array
    {
        $payload = self::trackerCopyFields($row, [
            'tested_at',
            'testerrorcaught',
            'status',
            'content',
            'lengthClass',
            'casing',
            'casingClass',
            'isEqualStatus',
            'isEqualClass',
            'contentImage',
            'dimensions',
            'widthImageClass',
            'heightImageClass',
            'contentImageAlt',
            'lengthImageAltClass',
        ]);

        if (isset($payload['dimensions'])) {
            $payload['dimensions'] = self::sanitizeTrackerDimensionsOnlyWh($payload['dimensions']);
        }

        return $payload;
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerImagesRow(array $row): array
    {
        $payload = self::trackerCopyFields($row, ['tested_at', 'status', 'testerrorcaught']);
        $payload['problems'] = [];

        if (! empty($row['problems']) && is_array($row['problems'])) {
            foreach ($row['problems'] as $prob) {
                $payload['problems'][] = self::trackerCopyFields(self::decodeTrackerMixedToArray($prob), [
                    'imageSrc',
                    'imageAlt',
                    'imageAltSpacesClass',
                    'imageAltSpacesStatus',
                    'imageName',
                    'imageLengthClass',
                    'imageLengthStatus',
                    'imageHyphenClass',
                    'imageHyphenStatus',
                    'imageUppercaseClass',
                    'imageUppercaseStatus',
                    'imageSpecialClass',
                    'imageSpecialStatus',
                    'imageSizeClass',
                    'imageSizeValue',
                    'status',
                ]);
            }
        }

        return $payload;
    }

    /** @param mixed $dimensions */
    private static function sanitizeTrackerDimensionsOnlyWh($dimensions): array
    {
        $arr = self::decodeTrackerMixedToArray($dimensions);

        return self::pickKeys($arr, ['w', 'h']);
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerGoogleOverallRow(array $row): array
    {
        if (isset($row['desktop_score']) || isset($row['mobile_score'])) {
            return [
                'desktop_score' => $row['desktop_score'] ?? null,
                'mobile_score' => $row['mobile_score'] ?? null,
            ];
        }

        return [
            'desktop_score' => self::trackerGoogleMetric($row, 'desktop', 'performance_score'),
            'mobile_score' => self::trackerGoogleMetric($row, 'mobile', 'performance_score'),
        ];
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerGoogleLighthouseRow(array $row): array
    {
        $keys = ['performance', 'accessibility', 'best_practices', 'seo'];
        $out = ['desktop' => [], 'mobile' => []];
        foreach (['desktop', 'mobile'] as $side) {
            foreach ($keys as $key) {
                $out[$side][$key] = self::trackerGoogleMetric($row, $side, $key.'_score');
            }
        }

        return $out;
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerCoreWebVitalsRow(array $row): array
    {
        $keys = [
            'lcp', 'fid', 'cls', 'fcp', 'interactive', 'speed_index', 'tbt',
        ];
        $map = [
            'lcp' => 'largest_contentful_paint',
            'fid' => 'max_potential_fid',
            'cls' => 'cumulative_layout_shift',
            'fcp' => 'first_contentful_paint',
            'interactive' => 'interactive',
            'speed_index' => 'speed_index',
            'tbt' => 'total_blocking_time',
        ];
        $out = ['desktop' => [], 'mobile' => []];
        foreach (['desktop', 'mobile'] as $side) {
            foreach ($keys as $short) {
                $long = $map[$short];
                $out[$side][$short] = self::trackerGoogleMetric($row, $side, $long);
            }
        }

        return $out;
    }

    /**
     * @param  array<string, mixed>  $row
     */
    private static function trackerGoogleMetric(array $row, string $side, string $field)
    {
        if (isset($row[$side]) && is_array($row[$side]) && array_key_exists($field, $row[$side])) {
            return $row[$side][$field];
        }
        if (! isset($row[$side])) {
            return null;
        }
        $block = self::decodeTrackerMixedToArray($row[$side]);
        $data = isset($block['data']) ? json_decode((string) $block['data'], true) : $block;

        return is_array($data) && array_key_exists($field, $data) ? $data[$field] : null;
    }

    /**
     * Pass/fail tracker cells (security, compression, caching, mobile friendly).
     *
     * @param  array<string, mixed>  $row
     * @return array<string, mixed>
     */
    private static function trackerPassFailRow(array $row): array
    {
        $out = [];
        if (array_key_exists('tested_at', $row)) {
            $out['tested_at'] = $row['tested_at'];
        }
        if (array_key_exists('testerrorcaught', $row)) {
            $out['testerrorcaught'] = self::trackerBool($row['testerrorcaught']);
        }
        if (array_key_exists('status', $row)) {
            $out['status'] = self::trackerBool($row['status']);
        }

        return $out;
    }

    /** @param  array<string, mixed>  $row */
    private static function trackerStatusOnlyRow(array $row): array
    {
        return self::trackerCopyFields($row, [
            'tested_at',
            'status',
            'testerrorcaught',
            'content',
            'lengthClass',
            'statusNumbers',
            'statusSpecial',
            'statusLowercase',
            'statusHyphens',
            'statusUnderscore',
            'statusStopWords',
            'contentLengthUnits',
        ]);
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private static function finalizeTrackerPayload(array $payload): array
    {
        return self::trackerStripRunTestBloat($payload);
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array<string, mixed>
     */
    private static function trackerStripRunTestBloat(array $row): array
    {
        foreach (self::TRACKER_RUNTEST_BLOAT_KEYS as $key) {
            unset($row[$key]);
        }

        return $row;
    }

    /**
     * @param  array<string, mixed>  $row
     */
    private static function trackerLengthPassStatus(array $row, string $content): bool
    {
        if (array_key_exists('status', $row) && ! is_string($row['status'])) {
            return self::trackerBool($row['status']);
        }
        if (isset($row['lengthClass'])) {
            return (string) $row['lengthClass'] === 'result_pass';
        }

        return $content !== '';
    }

    private static function trackerContentLength(string $content): int
    {
        return strlen($content);
    }

    private static function trackerBool($value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        if (is_numeric($value)) {
            return (int) $value !== 0;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param  mixed  $raw
     * @return array<string, mixed>
     */
    private static function decodeTrackerMixedToArray($raw): array
    {
        if ($raw === null || $raw === '' || $raw === []) {
            return [];
        }
        if (is_array($raw)) {
            return $raw;
        }
        if (is_string($raw)) {
            $trimmed = trim($raw);
            if ($trimmed !== '' && ($trimmed[0] === '{' || $trimmed[0] === '[')) {
                $decoded = json_decode($trimmed, true);
                if (is_array($decoded)) {
                    return $decoded;
                }
            }
        }
        if (is_object($raw)) {
            $decoded = json_decode(json_encode($raw), true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
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

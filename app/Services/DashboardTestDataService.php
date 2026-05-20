<?php

namespace App\Services;

use App\Models\DashboardTests;
use App\Models\DashboardTestsDetails;
use App\Models\projectSettings;
use App\Models\Projects;

/**
 * Aggregates dashboard test rows from `dashboard_tests_details` for API responses (dashboard / tracker).
 */
class DashboardTestDataService
{
    /** Keys stored in dashboard_tests_details but not loaded for tracker / website-tracker API. */
    private const TRACKER_OMITTED_TEST_KEYS = [
        'page_size',
    ];

    /**
     * dashboard_tests_details.data values may be JSON strings or already-decoded arrays.
     */
    public static function decodeDetailTestValue(mixed $value): mixed
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_object($value)) {
            return (array) $value;
        }

        if (! is_string($value) || trim($value) === '') {
            return $value;
        }

        $decoded = json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
    }

    private static function raiseMemoryLimitForAggregation(): ?string
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
                $cell = self::decodeDetailTestValue($value);

                if (isset($obj['security_labels'][$testKey])) {
                    $obj['security_labels'][$testKey][] = $cell;
                    continue;
                }

                if (isset($obj['cbp_labels'][$testKey])) {
                    $obj['cbp_labels'][$testKey][] = $cell;
                    continue;
                }

                if (isset($obj[$testKey])) {
                    $obj[$testKey][] = $cell;
                    continue;
                }
            }
        }

        return $obj;
    }

    /**
     * Tracker payload: same aggregation as dashboard but skips tests not shown on website-tracker.
     *
     * @param  iterable<int, \App\Models\DashboardTestsDetails>  $detailsIterable
     */
    public static function buildTrackerAggregatedResults(iterable $detailsIterable): array
    {
        $obj = self::emptyAggregatedResultsShell(includeTrackerOmitted: false);

        foreach ($detailsIterable as $detail) {
            if (! $detail->data) {
                continue;
            }

            $decoded = json_decode($detail->data, true);
            if (! is_array($decoded)) {
                continue;
            }

            foreach ($decoded as $testKey => $value) {
                if (in_array($testKey, self::TRACKER_OMITTED_TEST_KEYS, true)) {
                    continue;
                }

                $cell = self::stripTrackerRowSettings(self::decodeDetailTestValue($value));

                if (isset($obj['security_labels'][$testKey])) {
                    $obj['security_labels'][$testKey][] = $cell;
                    continue;
                }

                if (isset($obj['cbp_labels'][$testKey])) {
                    $obj['cbp_labels'][$testKey][] = $cell;
                    continue;
                }

                if (isset($obj[$testKey])) {
                    $obj[$testKey][] = $cell;
                }
            }
        }

        return $obj;
    }

    /**
     * @param  mixed  $row
     * @return mixed
     */
    private static function stripTrackerRowSettings($row)
    {
        if (! is_array($row)) {
            return $row;
        }

        if (isset($row['settings']) && is_array($row['settings'])) {
            $row['settings'] = self::slimTrackerRowSettingsArray($row['settings']);
        }

        unset($row['label']);

        return $row;
    }

    /**
     * Keep only sitemap URL keys from embedded project settings; drop full settings_sub blobs.
     *
     * @param  array<string, mixed>  $settings
     * @return array<string, mixed>
     */
    private static function slimTrackerRowSettingsArray(array $settings): array
    {
        $slim = [];
        foreach (['xml_sitemap_val', 'html_sitemap_val'] as $key) {
            if (isset($settings[$key]) && (string) $settings[$key] !== '') {
                $slim[$key] = $settings[$key];
            }
        }

        return $slim;
    }

    /**
     * @return array<string, mixed>
     */
    private static function emptyAggregatedResultsShell(bool $includeTrackerOmitted = true): array
    {
        $cbp = [
            'html_compression' => [],
            'css_compression' => [],
            'js_compression' => [],
            'gzip_compression' => [],
            'nested_tables' => [],
            'frameset' => [],
            'css_caching_enable' => [],
            'js_caching_enable' => [],
        ];

        if ($includeTrackerOmitted) {
            $cbp['page_size'] = [];
        }

        $shell = [
            'meta_title' => [],
            'meta_desc' => [],
            'robots_meta' => [],
            'canonical_url' => [],
            'url_slug' => [],
            'meta_viewport' => [],
            'doctype' => [],
            'favicon' => [],
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
            'cbp_labels' => $cbp,
            'google_overall' => [],
            'google_lighthouse' => [],
            'core_web_vitals' => [],
            'mobile_friendly' => [],
        ];

        if ($includeTrackerOmitted) {
            $shell['page_size'] = [];
        }

        return $shell;
    }

    public static function buildTestDataPayload(int $projectId, Projects $project, DashboardTests $dashboardTest): array
    {
        $prevMem = self::raiseMemoryLimitForAggregation();

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

    public static function buildTrackerTestDataPayload(int $projectId, Projects $project, DashboardTests $dashboardTest): array
    {
        $prevMem = self::raiseMemoryLimitForAggregation();

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

            $results = self::buildTrackerAggregatedResults($cursor);

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
}

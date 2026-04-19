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
}

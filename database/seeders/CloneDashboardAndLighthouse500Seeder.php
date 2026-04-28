<?php

namespace Database\Seeders;

use App\Models\DashboardTests;
use App\Models\DashboardTestsDetails;
use App\Models\LighthouseResult;
use App\Models\LighthouseTest;
use App\Models\projectSettings;
use App\Models\Projects;
use App\Models\SettingsSub;
use App\Models\TestLabel;
use App\Models\UrlsList;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CloneDashboardAndLighthouse500Seeder extends Seeder
{
    private const TARGET_URL_COUNT = 500;
    private const SEED_EMAIL = 'seed500@example.com';
    private const SEED_PASSWORD = 'password123';
    private const SEED_USER_NAME = 'Seed 500 User';
    private const SEED_PROJECT_NAME = 'Seed Project 500 URLs';

    public function run(): void
    {
        $sourceDashboard = DashboardTests::query()
            ->where('status', 'completed')
            ->latest('id')
            ->first();

        $isSynthetic = false;
        if ($sourceDashboard) {
            $sourceProject = Projects::query()->find($sourceDashboard->project_id);
            $sourceDetails = DashboardTestsDetails::query()
                ->where('dashboard_test_id', $sourceDashboard->id)
                ->whereNotNull('data')
                ->orderBy('id')
                ->get(['url', 'data', 'status', 'error_message']);
        } else {
            $sourceProject = null;
            $sourceDetails = collect();
        }

        if (! $sourceProject || $sourceDetails->isEmpty()) {
            $isSynthetic = true;
            $sourceProject = new Projects([
                'homepage' => 'https://example.com',
                'favicon' => '',
                'landing_page_preview' => '',
            ]);
            $sourceDetails = collect([
                (object) [
                    'url' => 'https://example.com',
                    'data' => $this->buildSyntheticDashboardDetailsData('https://example.com', 1),
                    'status' => 'completed',
                    'error_message' => null,
                ],
            ]);
        }

        DB::transaction(function () use ($sourceDashboard, $sourceProject, $sourceDetails): void {
            $now = Carbon::now();
            $seedUser = $this->upsertSeedUser();

            $this->deleteExistingSeedProjectData((int) $seedUser->id);

            $seedProject = Projects::query()->create([
                'user_id' => $seedUser->id,
                'name' => self::SEED_PROJECT_NAME,
                'homepage' => $sourceProject->homepage ?: 'https://seed-clone.local',
                'favicon' => $sourceProject->favicon ?: '',
                'landing_page_preview' => $sourceProject->landing_page_preview ?: '',
                'dashboard_show_status' => 1,
                'google_show_status' => 1,
                'recheck_type' => 'initial',
                'google_urls_checked_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $this->cloneProjectSettings((int) $sourceProject->id, (int) $seedProject->id);
            $this->cloneTestLabels((int) ($sourceProject->id ?? 0), (int) $seedProject->id, (int) $seedUser->id, $now);

            [$generatedUrls, $urlMap] = $this->buildGeneratedUrlsAndMap($sourceDetails);

            $this->insertProjectUrls((int) $seedProject->id, $generatedUrls);

            $newDashboard = DashboardTests::query()->create([
                'user_id' => $seedUser->id,
                'project_id' => $seedProject->id,
                'test_id' => (string) Str::uuid(),
                'urls' => json_encode($generatedUrls),
                'status' => 'completed',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $detailRows = [];
            $sourceCount = $sourceDetails->count();
            for ($i = 0; $i < self::TARGET_URL_COUNT; $i++) {
                $source = $sourceDetails[$i % $sourceCount];
                $oldUrl = (string) $source->url;
                $newUrl = $urlMap[$i];

                $detailRows[] = [
                    'dashboard_test_id' => $newDashboard->id,
                    'url' => $newUrl,
                    'data' => $this->replaceUrlInsideData((string) $source->data, $oldUrl, $newUrl),
                    'status' => $source->status ?: 'completed',
                    'error_message' => $source->error_message,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            foreach (array_chunk($detailRows, 200) as $chunk) {
                DashboardTestsDetails::query()->insert($chunk);
            }

            $this->cloneLighthouseForProject(
                (int) ($sourceProject->id ?? 0),
                (int) $seedProject->id,
                (int) $seedUser->id,
                $generatedUrls,
                $now,
                $sourceDetails
            );
        });

        if ($isSynthetic) {
            $this->command?->info('No completed source tests found; synthetic baseline data was generated.');
        }
        $this->command?->info('Seeded one login user + one project + 500 cloned dashboard/lighthouse URLs.');
        $this->command?->line('Email: ' . self::SEED_EMAIL);
        $this->command?->line('Password: ' . self::SEED_PASSWORD);
    }

    private function upsertSeedUser(): User
    {
        return User::query()->updateOrCreate(
            ['email' => self::SEED_EMAIL],
            [
                'name' => self::SEED_USER_NAME,
                'password' => Hash::make(self::SEED_PASSWORD),
                'email_verified_at' => Carbon::now(),
            ]
        );
    }

    private function deleteExistingSeedProjectData(int $seedUserId): void
    {
        $projectIds = Projects::query()
            ->where('user_id', $seedUserId)
            ->where('name', self::SEED_PROJECT_NAME)
            ->pluck('id')
            ->all();

        if (empty($projectIds)) {
            return;
        }

        $dashboardIds = DashboardTests::query()
            ->whereIn('project_id', $projectIds)
            ->pluck('id')
            ->all();

        if (! empty($dashboardIds)) {
            DashboardTestsDetails::query()->whereIn('dashboard_test_id', $dashboardIds)->delete();
            DashboardTests::query()->whereIn('id', $dashboardIds)->delete();
        }

        $lighthouseIds = LighthouseTest::query()
            ->whereIn('project_id', $projectIds)
            ->pluck('id')
            ->all();

        if (! empty($lighthouseIds)) {
            LighthouseResult::query()->whereIn('test_id', $lighthouseIds)->delete();
            LighthouseTest::query()->whereIn('id', $lighthouseIds)->delete();
        }

        $projectSettingsIds = DB::table('project_settings')
            ->whereIn('projects_id', $projectIds)
            ->pluck('id')
            ->all();
        if (! empty($projectSettingsIds)) {
            DB::table('project_settings_sub')->whereIn('project_settings_id', $projectSettingsIds)->delete();
        }
        DB::table('project_settings')->whereIn('projects_id', $projectIds)->delete();
        DB::table('test_labels')->whereIn('project_id', $projectIds)->delete();
        DB::table('urls')->whereIn('projects_id', $projectIds)->delete();
        Projects::query()->whereIn('id', $projectIds)->delete();
    }

    private function cloneProjectSettings(int $sourceProjectId, int $targetProjectId): void
    {
        $source = DB::table('project_settings')
            ->where('projects_id', $sourceProjectId)
            ->orderByDesc('id')
            ->first();

        if (! $source) {
            $newSettingsId = DB::table('project_settings')->insertGetId([
                'projects_id' => $targetProjectId,
            ]);
            DB::table('project_settings_sub')->insert([
                'project_settings_id' => $newSettingsId,
            ]);
            return;
        }

        $data = Arr::except((array) $source, ['id']);
        $data['projects_id'] = $targetProjectId;
        $newSettingsId = DB::table('project_settings')->insertGetId($data);

        $sourceSub = DB::table('project_settings_sub')
            ->where('project_settings_id', (int) $source->id)
            ->orderByDesc('id')
            ->first();

        if ($sourceSub) {
            $subData = Arr::except((array) $sourceSub, ['id']);
            $subData['project_settings_id'] = $newSettingsId;
            DB::table('project_settings_sub')->insert($subData);
        } else {
            DB::table('project_settings_sub')->insert([
                'project_settings_id' => $newSettingsId,
            ]);
        }
    }

    private function insertProjectUrls(int $projectId, array $urls): void
    {
        $rows = array_map(static function (string $url) use ($projectId): array {
            return [
                'projects_id' => $projectId,
                'url' => $url,
            ];
        }, $urls);

        foreach (array_chunk($rows, 200) as $chunk) {
            UrlsList::query()->insert($chunk);
        }
    }

    private function buildGeneratedUrlsAndMap($sourceDetails): array
    {
        $generatedUrls = [];
        $urlMap = [];
        $sourceCount = $sourceDetails->count();

        for ($i = 0; $i < self::TARGET_URL_COUNT; $i++) {
            $source = $sourceDetails[$i % $sourceCount];
            $newUrl = $this->buildCloneUrl((string) $source->url, $i + 1);
            $generatedUrls[] = $newUrl;
            $urlMap[$i] = $newUrl;
        }

        return [$generatedUrls, $urlMap];
    }

    private function cloneLighthouseForProject(int $sourceProjectId, int $targetProjectId, int $userId, array $generatedUrls, Carbon $now, Collection $sourceDetails): void
    {
        $latestLighthouse = LighthouseTest::query()
            ->where('project_id', $sourceProjectId)
            ->where('status', 'completed')
            ->latest('id')
            ->first();

        if ($latestLighthouse) {
            $sourceResults = LighthouseResult::query()
                ->where('test_id', $latestLighthouse->id)
                ->orderBy('id')
                ->get(['url', 'strategy', 'data', 'status', 'error_message']);
        } else {
            $sourceResults = collect();
        }

        if ($sourceResults->isEmpty()) {
            $sourceUrl = (string) ($sourceDetails->first()->url ?? 'https://example.com');
            $sourceResults = collect([
                (object) [
                    'url' => $sourceUrl,
                    'strategy' => 'mobile',
                    'data' => json_encode($this->buildSyntheticLighthouseData($sourceUrl, 'mobile')),
                    'status' => 'completed',
                    'error_message' => null,
                ],
                (object) [
                    'url' => $sourceUrl,
                    'strategy' => 'desktop',
                    'data' => json_encode($this->buildSyntheticLighthouseData($sourceUrl, 'desktop')),
                    'status' => 'completed',
                    'error_message' => null,
                ],
            ]);
        }

        $groupedByUrl = $sourceResults->groupBy('url')->values();
        if ($groupedByUrl->isEmpty()) {
            return;
        }

        $newLighthouse = LighthouseTest::query()->create([
            'user_id' => $userId,
            'project_id' => $targetProjectId,
            'test_id' => (string) Str::uuid(),
            'urls' => json_encode($generatedUrls),
            'completed_urls' => json_encode($generatedUrls),
            'status' => 'completed',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $rows = [];
        $groupsCount = $groupedByUrl->count();
        foreach ($generatedUrls as $idx => $newUrl) {
            $group = $groupedByUrl[$idx % $groupsCount];
            $oldUrl = (string) ($group->first()->url ?? '');

            foreach ($group as $resultRow) {
                $data = $resultRow->data;
                if (is_string($data) && $oldUrl !== '') {
                    $data = str_replace($oldUrl, $newUrl, $data);
                }

                $rows[] = [
                    'test_id' => $newLighthouse->id,
                    'url' => $newUrl,
                    'strategy' => $resultRow->strategy,
                    'data' => $data,
                    'status' => $resultRow->status ?: 'completed',
                    'error_message' => $resultRow->error_message,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        foreach (array_chunk($rows, 200) as $chunk) {
            LighthouseResult::query()->insert($chunk);
        }
    }

    private function replaceUrlInsideData(string $data, string $oldUrl, string $newUrl): string
    {
        if ($oldUrl === '' || $oldUrl === $newUrl) {
            return $data;
        }

        return str_replace($oldUrl, $newUrl, $data);
    }

    private function buildCloneUrl(string $sourceUrl, int $index): string
    {
        if ($sourceUrl === '') {
            return "https://seed-clone.local/url-{$index}";
        }

        $sep = str_contains($sourceUrl, '?') ? '&' : '?';

        return "{$sourceUrl}{$sep}seed_clone={$index}";
    }

    private function buildSyntheticDashboardDetailsData(string $url, int $index): string
    {
        $score = 80 + ($index % 20);
        $base = [
            'tested_url' => $url,
            'url' => $url,
            'content' => "sample-content-{$index}",
            'status' => true,
        ];

        $payload = [
            'meta_title' => json_encode($base + ['title' => "Sample Title {$index}", 'length' => 20, 'statusLength' => true]),
            'meta_desc' => json_encode($base + ['description' => "Sample description {$index}", 'length' => 60]),
            'robots_meta' => json_encode($base + ['indexStatus' => true, 'followStatus' => true]),
            'canonical_url' => json_encode($base + ['canonical' => $url]),
            'url_slug' => json_encode($base + ['content' => "sample-slug-{$index}", 'statusHyphens' => true, 'statusUnderscore' => false, 'statusNumbers' => false, 'statusSpecial' => false, 'statusLowercase' => true, 'statusStopWords' => false, 'lengthClass' => 'result_pass']),
            'meta_viewport' => json_encode($base),
            'doctype' => json_encode($base),
            'favicon' => json_encode($base + ['content' => $url . '/favicon.ico']),
            'page_size' => json_encode($base + ['sizeKb' => 200 + $index]),
            'xml_sitemap' => json_encode($base + ['found' => true, 'locCount' => 10]),
            'html_sitemap' => json_encode($base + ['found' => true, 'locCount' => 10]),
            'images' => json_encode($base + ['totalImages' => 3, 'problems' => []]),
            'open_graph_tags' => json_encode($base + ['missing' => 0]),
            'twitter_tags' => json_encode($base + ['missing' => 0]),
            'http_status_code' => json_encode($base + ['status_code' => 200]),
            'broken_links' => json_encode($base + ['internalBrokenLinks' => [], 'externalBrokenLinks' => []]),
            'robot_text_test' => json_encode($base + ['found' => true]),
            'h1_heading_tag' => json_encode($base + ['h1Count' => 1]),
            'mobile_friendly' => json_encode($base + ['mobileFriendly' => true]),
            'is_safe_browsing' => json_encode($base + ['status' => true]),
            'cross_origin_links' => json_encode($base + ['status' => true]),
            'protocol_relative_resource' => json_encode($base + ['status' => true]),
            'content_security_policy_header' => json_encode($base + ['status' => true]),
            'x_frame_options_header' => json_encode($base + ['status' => true]),
            'hsts_header' => json_encode($base + ['status' => true]),
            'bad_content_type' => json_encode($base + ['status' => false]),
            'ssl_certificate_enable' => json_encode($base + ['status' => true]),
            'folder_browsing_enable' => json_encode($base + ['status' => false]),
            'html_compression' => json_encode($base + ['status' => true]),
            'css_compression' => json_encode($base + ['status' => true]),
            'js_compression' => json_encode($base + ['status' => true]),
            'gzip_compression' => json_encode($base + ['status' => true]),
            'nested_tables' => json_encode($base + ['status' => false]),
            'frameset' => json_encode($base + ['status' => false]),
            'css_caching_enable' => json_encode($base + ['status' => true]),
            'js_caching_enable' => json_encode($base + ['status' => true]),
            'google_overall' => json_encode($base + ['score' => $score]),
            'google_lighthouse' => json_encode($base + ['score' => $score]),
            'core_web_vitals' => json_encode($base + ['score' => $score]),
        ];

        return json_encode($payload);
    }

    private function buildSyntheticLighthouseData(string $url, string $strategy): array
    {
        return [
            'id' => $url,
            'requestedUrl' => $url,
            'finalUrl' => $url,
            'strategy' => $strategy,
            'lighthouseResult' => [
                'requestedUrl' => $url,
                'finalUrl' => $url,
                'categories' => [
                    'performance' => ['score' => 0.88],
                    'accessibility' => ['score' => 0.92],
                    'best-practices' => ['score' => 0.9],
                    'seo' => ['score' => 0.93],
                ],
                'audits' => [
                    'first-contentful-paint' => ['displayValue' => '1.0 s'],
                    'largest-contentful-paint' => ['displayValue' => '1.6 s'],
                    'cumulative-layout-shift' => ['displayValue' => '0.01'],
                    'speed-index' => ['displayValue' => '2.0 s'],
                    'interactive' => ['displayValue' => '2.4 s'],
                ],
            ],
        ];
    }

    private function cloneTestLabels(int $sourceProjectId, int $targetProjectId, int $userId, Carbon $now): void
    {
        $sourceRows = TestLabel::query()
            ->where('project_id', $sourceProjectId)
            ->orderBy('id')
            ->get();

        if ($sourceRows->isNotEmpty()) {
            $rows = $sourceRows->map(function ($row) use ($targetProjectId, $userId, $now) {
                return [
                    'user_id' => $userId,
                    'project_id' => $targetProjectId,
                    'urlDetails' => $row->urlDetails,
                    'reportsUrl' => $row->reportsUrl,
                    'display_name' => $row->display_name,
                    'name' => $row->name,
                    'db_name' => $row->db_name,
                    'url' => $row->url,
                    'is_dashboard_status' => (int) $row->is_dashboard_status,
                    'analysis_status' => (int) $row->analysis_status,
                    'bulk_status' => (int) $row->bulk_status,
                    'show_dashboard_status' => $row->show_dashboard_status === null ? 1 : (int) $row->show_dashboard_status,
                    'has_dashboard_parent' => $row->has_dashboard_parent === null ? 0 : (int) $row->has_dashboard_parent,
                    'dashboard_parent' => $row->dashboard_parent,
                    'parent' => $row->parent,
                    'initialTestingState' => isset($row->initialTestingState) ? (int) $row->initialTestingState : 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })->all();

            foreach (array_chunk($rows, 200) as $chunk) {
                DB::table('test_labels')->insert($chunk);
            }
            return;
        }

        $defaults = [
            ['Meta Title', 'meta_title', '/test-details/title', '/reports/meta-title', '/test/title', 'seo'],
            ['Meta Description', 'meta_desc', '/test-details/description', '/reports/description', '/test/description', 'seo'],
            ['Robots Meta Tag', 'robots_meta', '/test-details/robots-meta', '/reports/robots-meta', '/test/robots-meta', 'seo'],
            ['Canonical Tag', 'canonical_url', '/test-details/canonical-url', '/reports/canonical-url', '/test/canonical-url', 'seo'],
            ['URL Slug', 'url_slug', '/test-details/url-slug', '/reports/url-slug', '/test/url-slug', 'seo'],
            ['Meta Viewport', 'meta_viewport', '/test-details/meta-viewport', '/reports/meta-viewport', '/test/meta-viewport', 'seo'],
            ['Doctype', 'doctype', '/test-details/doctype', '/reports/doctype', '/test/doctype', 'seo'],
            ['Favicon', 'favicon', '/test-details/favicon', '/reports/favicon', '/test/favicon', 'seo'],
            ['Sitemap', 'xml_sitemap', '/test-details/xml-sitemap', '/reports/xml-sitemap', '/test/xml-sitemap', 'seo'],
            ['HTML Sitemap', 'html_sitemap', '/test-details/html-sitemap', '/reports/html-sitemap', '/test/html-sitemap', 'seo'],
            ['Open Graph Tags', 'open_graph_tags', '/test-details/og-tags', '/reports/og-tags', '/test/og-tags', 'seo'],
            ['Twitter Tags', 'twitter_tags', '/test-details/twitter-tags', '/reports/twitter-tags', '/test/twitter-tags', 'seo'],
            ['HTTP Status Code', 'http_status_code', '/test-details/http-status-code', '/reports/http-status-code', '/test/http-status-code', 'seo'],
            ['Broken Links', 'broken_links', '/test-details/broken-links', '/reports/broken-links', '/test/broken-links', 'seo'],
            ['Robots.txt', 'robot_text_test', '/test-details/robot-text', '/reports/robot-text', '/test/robot-text', 'seo'],
            ['H1 Heading Tag', 'h1_heading_tag', '/test-details/h1-heading', '/reports/h1-heading', '/test/h1-heading', 'seo'],
            ['Page Speed Overall Score', 'google_overall', '/test-details/google-page-speed-insights', '/reports/google-page-speed-insights', '/test/google-page-speed-insights', 'performance'],
            ['Page Speed Lighthouse Score', 'google_lighthouse', '/test-details/google-page-speed-lighthouse', '/reports/google-page-speed-lighthouse', '/test/google-page-speed-lighthouse', 'performance'],
            ['Page Speed Core Web Vitals', 'core_web_vitals', '/test-details/google-page-speed-core-web-vitals', '/reports/google-page-speed-core-web-vitals', '/test/google-page-speed-core-web-vitals', 'performance'],
            ['Mobile Friendly', 'mobile_friendly', '/test-details/mobile-friendly', '/reports/mobile-friendly', '/test/mobile-friendly', 'performance'],
            ['Safe Browsing', 'is_safe_browsing', '/test-details/is-safe-browsing', '/reports/is-safe-browsing', '/test/is-safe-browsing', 'security'],
            ['Cross Origin Links', 'cross_origin_links', '/test-details/cross-origin-links', '/reports/cross-origin-links', '/test/cross-origin-links', 'security'],
            ['Protocol Relative Resource', 'protocol_relative_resource', '/test-details/protocol-relative-resource', '/reports/protocol-relative-resource', '/test/protocol-relative-resource', 'security'],
            ['Content Security Policy Header', 'content_security_policy_header', '/test-details/content-security-policy-header', '/reports/content-security-policy-header', '/test/content-security-policy-header', 'security'],
            ['X Frame Options Header', 'x_frame_options_header', '/test-details/x-frame-options-header', '/reports/x-frame-options-header', '/test/x-frame-options-header', 'security'],
            ['HSTS Header', 'hsts_header', '/test-details/hsts-header', '/reports/hsts-header', '/test/hsts-header', 'security'],
            ['Bad Content Type', 'bad_content_type', '/test-details/bad-content-type', '/reports/bad-content-type', '/test/bad-content-type', 'security'],
            ['SSL Certificate Enable', 'ssl_certificate_enable', '/test-details/ssl-certificate-enable', '/reports/ssl-certificate-enable', '/test/ssl-certificate-enable', 'security'],
            ['Folder Browsing', 'folder_browsing_enable', '/test-details/folder-browsing-enable', '/reports/folder-browsing-enable', '/test/folder-browsing-enable', 'security'],
            ['HTML Compression', 'html_compression', '/test-details/html-compression', '/reports/html-compression', '/test/html-compression', 'best-practices'],
            ['CSS Compression', 'css_compression', '/test-details/css-compression', '/reports/css-compression', '/test/css-compression', 'best-practices'],
            ['JS Compression', 'js_compression', '/test-details/js-compression', '/reports/js-compression', '/test/js-compression', 'best-practices'],
            ['GZIP Compression', 'gzip_compression', '/test-details/gzip-compression', '/reports/gzip-compression', '/test/gzip-compression', 'best-practices'],
            ['Nested Tables', 'nested_tables', '/test-details/nested-tables', '/reports/nested-tables', '/test/nested-tables', 'best-practices'],
            ['Frameset', 'frameset', '/test-details/frameset', '/reports/frameset', '/test/frameset', 'best-practices'],
            ['CSS Caching Enable', 'css_caching_enable', '/test-details/css-caching-enable', '/reports/css-caching-enable', '/test/css-caching-enable', 'best-practices'],
            ['JS Caching Enable', 'js_caching_enable', '/test-details/js-caching-enable', '/reports/js-caching-enable', '/test/js-caching-enable', 'best-practices'],
        ];

        $securityChildren = ['is_safe_browsing', 'cross_origin_links', 'protocol_relative_resource', 'content_security_policy_header', 'x_frame_options_header', 'hsts_header', 'bad_content_type', 'ssl_certificate_enable', 'folder_browsing_enable'];
        $cbpChildren = ['html_compression', 'css_compression', 'js_compression', 'gzip_compression', 'nested_tables', 'frameset', 'css_caching_enable', 'js_caching_enable'];
        $rows = [];

        foreach ($defaults as $item) {
            [$displayName, $dbName, $urlDetails, $reportsUrl, $url, $parent] = $item;
            $hasParent = in_array($dbName, $securityChildren, true) || in_array($dbName, $cbpChildren, true);
            $dashboardParent = in_array($dbName, $securityChildren, true) ? 'security_labels' : (in_array($dbName, $cbpChildren, true) ? 'cbp_labels' : '');

            $rows[] = [
                'user_id' => $userId,
                'project_id' => $targetProjectId,
                'urlDetails' => $urlDetails,
                'reportsUrl' => $reportsUrl,
                'display_name' => $displayName,
                'name' => $dbName,
                'db_name' => $dbName,
                'url' => $url,
                'is_dashboard_status' => 1,
                'analysis_status' => 1,
                'bulk_status' => 1,
                'show_dashboard_status' => 1,
                'has_dashboard_parent' => $hasParent ? 1 : 0,
                'dashboard_parent' => $dashboardParent,
                'parent' => $parent,
                'initialTestingState' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table('test_labels')->insert($rows);
    }
}


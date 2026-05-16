<?php

namespace App\Console\Commands;

use App\Models\DashboardTests;
use App\Models\Projects;
use App\Services\DashboardTrackerCacheService;
use Illuminate\Console\Command;

class RebuildTrackerCacheCommand extends Command
{
    protected $signature = 'tracker:rebuild-cache {project_id : Project ID}';

    protected $description = 'Re-sanitize cached_tracker_details from dashboard_tests_details for a project';

    public function handle(): int
    {
        $projectId = (int) $this->argument('project_id');
        $project = Projects::find($projectId);

        if (! $project) {
            $this->error("Project {$projectId} not found.");

            return self::FAILURE;
        }

        $dashboardTest = DashboardTests::where('project_id', $projectId)->latest()->first();
        if (! $dashboardTest) {
            $this->error('No dashboard test found for this project.');

            return self::FAILURE;
        }

        if (! DashboardTrackerCacheService::canUseCacheTables()) {
            $this->error('Cache tables are missing. Run migrations first.');

            return self::FAILURE;
        }

        DashboardTrackerCacheService::finalizeDashboardTestAndRefreshCaches(
            $projectId,
            (int) $project->user_id,
            (int) $dashboardTest->id,
            'default',
            null
        );

        $this->info("Tracker cache rebuilt for project {$projectId} (dashboard test #{$dashboardTest->id}).");

        return self::SUCCESS;
    }
}

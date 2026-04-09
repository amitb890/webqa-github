<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $projects = DB::table('projects')->select('id', 'user_id')->get();

        foreach ($projects as $p) {
            $exists = DB::table('test_labels')
                ->where('project_id', $p->id)
                ->where('db_name', 'h1_heading_tag')
                ->exists();

            if ($exists) {
                continue;
            }

            DB::table('test_labels')->insert([
                'user_id' => $p->user_id,
                'project_id' => $p->id,
                'urlDetails' => '/test-details/headings',
                'reportsUrl' => '/reports/headings',
                'display_name' => 'Headings',
                'name' => 'h1_heading_tag',
                'db_name' => 'h1_heading_tag',
                'url' => '/test/headings',
                'is_dashboard_status' => 1,
                'analysis_status' => 1,
                'bulk_status' => 1,
                'show_dashboard_status' => 1,
                'has_dashboard_parent' => 0,
                'dashboard_parent' => '',
                'parent' => 'seo',
                'initialTestingState' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('test_labels')->where('db_name', 'h1_heading_tag')->delete();
    }
};

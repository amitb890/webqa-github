<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('project_ui_snapshots')) {
            return;
        }

        $needsTestData = ! Schema::hasColumn('project_ui_snapshots', 'cached_test_data_json');
        $needsLighthouse = ! Schema::hasColumn('project_ui_snapshots', 'cached_lighthouse_json');
        if (! $needsTestData && ! $needsLighthouse) {
            return;
        }

        Schema::table('project_ui_snapshots', function (Blueprint $table) use ($needsTestData, $needsLighthouse) {
            if ($needsTestData) {
                $table->longText('cached_test_data_json')->nullable()->after('payload');
            }
            if ($needsLighthouse) {
                $table->longText('cached_lighthouse_json')->nullable()->after('cached_test_data_json');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('project_ui_snapshots')) {
            return;
        }

        $drop = [];
        if (Schema::hasColumn('project_ui_snapshots', 'cached_test_data_json')) {
            $drop[] = 'cached_test_data_json';
        }
        if (Schema::hasColumn('project_ui_snapshots', 'cached_lighthouse_json')) {
            $drop[] = 'cached_lighthouse_json';
        }
        if ($drop === []) {
            return;
        }

        Schema::table('project_ui_snapshots', function (Blueprint $table) use ($drop) {
            $table->dropColumn($drop);
        });
    }
};

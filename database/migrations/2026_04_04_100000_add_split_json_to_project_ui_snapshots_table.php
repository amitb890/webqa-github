<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_ui_snapshots', function (Blueprint $table) {
            $table->longText('cached_test_data_json')->nullable()->after('payload');
            $table->longText('cached_lighthouse_json')->nullable()->after('cached_test_data_json');
        });
    }

    public function down(): void
    {
        Schema::table('project_ui_snapshots', function (Blueprint $table) {
            $table->dropColumn(['cached_test_data_json', 'cached_lighthouse_json']);
        });
    }
};

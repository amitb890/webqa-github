<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->string('settings_mode', 32)->nullable()->after('http_user_agent');
            $table->unsignedBigInteger('project_id')->nullable()->after('settings_mode');
            $table->longText('settings_snapshot')->nullable()->after('project_id');
        });
    }

    public function down(): void
    {
        Schema::table('test_results', function (Blueprint $table) {
            $table->dropColumn(['settings_mode', 'project_id', 'settings_snapshot']);
        });
    }
};

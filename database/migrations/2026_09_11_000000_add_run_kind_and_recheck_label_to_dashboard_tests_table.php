<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dashboard_tests', function (Blueprint $table) {
            $table->string('run_kind', 32)->nullable()->after('status');
            $table->string('recheck_label', 64)->nullable()->after('run_kind');
        });
    }

    public function down(): void
    {
        Schema::table('dashboard_tests', function (Blueprint $table) {
            $table->dropColumn(['run_kind', 'recheck_label']);
        });
    }
};

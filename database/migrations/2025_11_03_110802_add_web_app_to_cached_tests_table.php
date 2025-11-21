<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cached_tests', function (Blueprint $table) {
            if (!Schema::hasColumn('cached_tests', 'web_app')) {
                $table->boolean('web_app')
                      ->default(0)
                      ->after('projectUrl')
                      ->comment('1 = app-analysis, 0 = analysis');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cached_tests', function (Blueprint $table) {
            if (Schema::hasColumn('cached_tests', 'web_app')) {
                $table->dropColumn('web_app');
            }
        });
    }
};

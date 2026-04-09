<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('report_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('report_settings', 'html_sitemap')) {
                $table->boolean('html_sitemap')->default(1)->after('xml_sitemap');
            }
        });
    }

    public function down(): void
    {
        Schema::table('report_settings', function (Blueprint $table) {
            if (Schema::hasColumn('report_settings', 'html_sitemap')) {
                $table->dropColumn('html_sitemap');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeSitemapValColumnsToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE project_settings_sub MODIFY xml_sitemap_val TEXT NULL');
        DB::statement('ALTER TABLE project_settings_sub MODIFY html_sitemap_val TEXT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE project_settings_sub MODIFY xml_sitemap_val VARCHAR(255) NULL DEFAULT ''");
        DB::statement("ALTER TABLE project_settings_sub MODIFY html_sitemap_val VARCHAR(255) NULL DEFAULT ''");
    }
}

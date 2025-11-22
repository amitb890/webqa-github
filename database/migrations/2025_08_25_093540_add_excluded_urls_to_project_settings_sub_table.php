<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExcludedUrlsToProjectSettingsSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_settings_sub', function (Blueprint $table) {
            $table->boolean("broken_links_exclude_urls")->default(0)->nullable();
            $table->text("broken_links_excluded_urls")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_settings_sub', function (Blueprint $table) {
            $table->dropColumn("broken_links_exclude_urls");
            $table->dropColumn("broken_links_excluded_urls");
        });
    }
}

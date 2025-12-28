<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeHeadingTagLengthDefaultsToZeroInProjectSettingsSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_settings_sub', function (Blueprint $table) {
            $table->boolean("h1_heading_tag_length")->default(0)->change();
            $table->boolean("h2_heading_tag_length")->default(0)->change();
            $table->boolean("h3_heading_tag_length")->default(0)->change();
            $table->boolean("h4_heading_tag_length")->default(0)->change();
            $table->boolean("h5_heading_tag_length")->default(0)->change();
            $table->boolean("h6_heading_tag_length")->default(0)->change();
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
            $table->boolean("h1_heading_tag_length")->default(1)->change();
            $table->boolean("h2_heading_tag_length")->default(1)->change();
            $table->boolean("h3_heading_tag_length")->default(1)->change();
            $table->boolean("h4_heading_tag_length")->default(1)->change();
            $table->boolean("h5_heading_tag_length")->default(1)->change();
            $table->boolean("h6_heading_tag_length")->default(1)->change();
        });
    }
}


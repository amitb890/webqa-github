<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchemaToProjectSettingsSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_settings_sub', function (Blueprint $table) {
            $table->boolean('schema_test')->default(0)->nullable();
            $table->boolean('schema_test_custom')->default(1)->nullable();
            $table->text('schema_val')->nullable();
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
            $table->dropColumn(['schema_test', 'schema_test_custom', 'schema_val']);
        });
    }
}


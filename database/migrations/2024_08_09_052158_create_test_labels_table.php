<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_labels', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("project_id");
            $table->string("urlDetails");
            $table->string("reportsUrl");
            $table->string("display_name");
            $table->string("name");
            $table->string("db_name");
            $table->string("url");
            $table->boolean("is_dashboard_status");
            $table->boolean("analysis_status");
            $table->boolean("bulk_status");
            $table->boolean("show_dashboard_status")->nullable();
            $table->boolean("has_dashboard_parent")->nullable();
            $table->string("dashboard_parent")->nullable();
            $table->string("parent");
            $table->boolean("initialTestingState");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_labels');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_test_details', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("project_id");
            $table->string("url");
            $table->integer("status");
            $table->string("test_title")->nullable();
            $table->longText("label")->nullable();
            $table->longText("data")->nullable();
            $table->text("http_user_agent")->nullable();
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
        Schema::dropIfExists('project_test_details');
    }
}

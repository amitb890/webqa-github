<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_tests', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("project_id");
            $table->string('test_id')->unique();
            $table->longText('urls');
            $table->enum('status', ['pending', 'recheck', 'recheck-single', 'in_progress', 'completed'])->default('pending');
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
        Schema::dropIfExists('dashboard_tests');
    }
}

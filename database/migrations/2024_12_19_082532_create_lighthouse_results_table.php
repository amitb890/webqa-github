<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLighthouseResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lighthouse_results', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("project_id");
            $table->string('test_id')->unique();
            $table->text('urls');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->json('results')->nullable(); // Store the performance scores as JSON
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
        Schema::dropIfExists('lighthouse_results');
    }
}

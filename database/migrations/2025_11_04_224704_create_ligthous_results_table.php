<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLigthousResultsTable extends Migration
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
            $table->unsignedBigInteger('test_id');
            $table->string('url');
            $table->string('strategy'); // desktop or mobile
            $table->json('data')->nullable();
            $table->string('status')->default('pending'); // pending | completed | failed
            $table->text('error_message')->nullable();
            $table->timestamps();
        
            $table->foreign('test_id')->references('id')->on('lighthouse_tests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lighthouse_tests');
    }
}

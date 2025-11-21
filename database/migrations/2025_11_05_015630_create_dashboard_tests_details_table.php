<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardTestsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_tests_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dashboard_test_id')->constrained('dashboard_tests')->onDelete('cascade');
            $table->longText('url');
            $table->json('data')->nullable();
            $table->string('status')->default('pending'); // pending | completed | failed
            $table->text('error_message')->nullable();
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
        Schema::dropIfExists('dashboard_tests_details');
    }
}

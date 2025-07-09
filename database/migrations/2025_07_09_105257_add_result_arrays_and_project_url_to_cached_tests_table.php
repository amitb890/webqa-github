<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('cached_tests', function (Blueprint $table) {
            $table->json('resultsData')->nullable()->after('test_labels');
            $table->json('dataFailed')->nullable()->after('resultsData');
            $table->json('dataPassed')->nullable()->after('dataFailed');
            $table->string('projectUrl')->nullable()->after('dataPassed');
        });
    }

    public function down()
    {
        Schema::table('cached_tests', function (Blueprint $table) {
            $table->dropColumn(['resultsData', 'dataFailed', 'dataPassed', 'projectUrl']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompletionEmailFieldsToLighthouseTestsTable extends Migration
{
    public function up()
    {
        Schema::table('lighthouse_tests', function (Blueprint $table) {
            $table->boolean('send_completion_email')->default(true)->after('status');
            $table->timestamp('completion_email_sent_at')->nullable()->after('send_completion_email');
        });
    }

    public function down()
    {
        Schema::table('lighthouse_tests', function (Blueprint $table) {
            $table->dropColumn(['send_completion_email', 'completion_email_sent_at']);
        });
    }
}

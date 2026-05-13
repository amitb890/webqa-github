<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->unsignedTinyInteger('dashboard_fully_tested')->default(0)->after('dashboard_show_status');
        });

        Schema::create('cached_dashboard_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id');
            $table->string('widget_key', 128);
            $table->longText('widget_data_json')->nullable();
            $table->timestamps();

            $table->unique(['project_id', 'user_id', 'widget_key'], 'cached_dashboard_project_user_widget_unique');
            $table->index(['project_id', 'user_id'], 'cached_dashboard_project_user_index');
        });

        Schema::create('cached_tracker_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('user_id');
            $table->longText('url')->nullable();
            $table->string('widget_key', 128);
            $table->longText('widget_data_json')->nullable();
            $table->timestamps();

            $table->unique(['project_id', 'user_id', 'url', 'widget_key'], 'cached_tracker_project_user_url_widget_unique');
            $table->index(['project_id', 'user_id'], 'cached_tracker_project_user_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cached_tracker_details');
        Schema::dropIfExists('cached_dashboard_details');

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('dashboard_fully_tested');
        });
    }
};

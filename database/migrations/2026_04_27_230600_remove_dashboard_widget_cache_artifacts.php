<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('project_dashboard_widget_caches')) {
            Schema::drop('project_dashboard_widget_caches');
        }

        if (Schema::hasColumn('projects', 'dashboard_fully_done_status')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('dashboard_fully_done_status');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('projects', 'dashboard_fully_done_status')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->unsignedTinyInteger('dashboard_fully_done_status')->default(0);
            });
        }

        if (! Schema::hasTable('project_dashboard_widget_caches')) {
            Schema::create('project_dashboard_widget_caches', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('project_id');
                $table->string('widget_key', 128);
                $table->json('payload');
                $table->timestamps();

                $table->unique(['project_id', 'widget_key']);
                $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            });
        }
    }
};


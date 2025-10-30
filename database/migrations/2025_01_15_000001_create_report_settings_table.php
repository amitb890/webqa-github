<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_settings', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->nullable();
            $table->boolean("meta_title")->default(1);
            $table->boolean("meta_desc")->default(1);
            $table->boolean("robots_meta")->default(1);
            $table->boolean("canonical_url")->default(1);
            $table->boolean("url_slug")->default(1);
            $table->boolean("open_graph_tags")->default(1);
            $table->boolean("twitter_tags")->default(1);
            $table->boolean("favicon")->default(1);
            $table->boolean("xml_sitemap")->default(1);
            $table->boolean("meta_viewport")->default(1);
            $table->boolean("frameset")->default(1);
            $table->boolean("doctype")->default(1);
            $table->boolean("http_status_code")->default(1);
            $table->boolean("page_size")->default(1);
            $table->boolean("hsts_header")->default(1);
            $table->boolean("content_security_policy_header")->default(1);
            $table->boolean("nested_tables")->default(1);
            $table->boolean("x_frame_options_header")->default(1);
            $table->boolean("ssl_certificate_enable")->default(1);
            $table->boolean("bad_content_type")->default(1);
            $table->boolean("folder_browsing_enable")->default(1);
            $table->boolean("css_caching_enable")->default(1);
            $table->boolean("js_caching_enable")->default(1);
            $table->boolean("mobile_friendly")->default(1);
            $table->boolean("is_safe_browsing")->default(1);
            $table->boolean("cross_origin_links")->default(1);
            $table->boolean("protocol_relative_resource")->default(1);
            $table->boolean("h1_heading_tag")->default(1);
            $table->boolean("robot_text_test")->default(1);
            $table->boolean("broken_links")->default(1);
            $table->boolean("images")->default(1);
            $table->boolean("html_compression")->default(1);
            $table->boolean("css_compression")->default(1);
            $table->boolean("js_compression")->default(1);
            $table->boolean("gzip_compression")->default(1);
            $table->boolean("google_overall")->default(1);
            $table->boolean("google_lighthouse")->default(1);
            $table->boolean("core_web_vitals")->default(1);
            $table->enum('type',['default','user'])->default('user');
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
        Schema::dropIfExists('report_settings');
    }
}

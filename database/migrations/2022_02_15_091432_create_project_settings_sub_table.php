<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectSettingsSubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_settings_sub', function (Blueprint $table) {
            $table->id();
            $table->integer("project_settings_id");
            $table->boolean("meta_title")->default(1)->nullable();
            $table->boolean("max_title_length")->default(1)->nullable();
            $table->bigInteger("max_title_length_val")->default(65)->nullable();
            $table->boolean("min_title_length")->default(0)->nullable();
            $table->bigInteger("min_title_length_val")->default(0)->nullable();
            $table->boolean("is_title_equal_h1")->default(1)->nullable();
            $table->boolean("title_casing_both")->default(1)->nullable();
            $table->boolean("title_casing_camel")->default(0)->nullable();
            $table->boolean("title_casing_sentence")->default(0)->nullable();
            $table->boolean("is_excluded_words")->default(0)->nullable();
            $table->text("excluded_words")->nullable()->default("");
            $table->boolean("image_max_size")->default(1)->nullable();
            $table->bigInteger("image_max_size_val")->default(150)->nullable();
            $table->boolean("image_name_only_hyphens")->default(1)->nullable();
            $table->boolean("image_name_no_uppercase")->default(1)->nullable();
            $table->boolean("image_name_no_special")->default(1)->nullable();
            $table->boolean("image_name_max_characters")->default(1)->nullable();
            $table->bigInteger("image_name_max_characters_val")->default(50)->nullable();
            $table->boolean("image_alt")->default(1)->nullable();
            $table->boolean("image_alt_only_spaces")->default(1)->nullable();
            $table->boolean("meta_desc")->default(1)->nullable();
            $table->boolean("max_desc_length")->default(1)->nullable();
            $table->bigInteger("max_desc_length_val")->default(160)->nullable();
            $table->boolean("min_desc_length")->default(0)->nullable();
            $table->boolean("min_desc_length_val")->default(0)->nullable();
            $table->boolean("staging_urls_robots_meta")->default(1)->nullable();
            $table->boolean("live_urls_robots_meta")->default(1)->nullable();
            $table->boolean("canonical_url")->default(1)->nullable();
            $table->boolean("canonical_url_equal_url")->default(1)->nullable();
            $table->boolean("canonical_url_ignore_slash")->default(1)->nullable();
            $table->boolean("url_slug_lowercase")->default(1)->nullable();
            $table->boolean("url_no_numbers")->default(0)->nullable();
            $table->boolean("url_no_special")->default(1)->nullable();
            $table->boolean("max_url_length")->default(1)->nullable();
            $table->bigInteger("max_url_length_val")->default(60)->nullable();
            $table->boolean("url_casing_only_hyphens")->default(1)->nullable();
            $table->boolean("url_casing_only_underscores")->default(0)->nullable();
            $table->boolean("url_casing_both")->default(0)->nullable();
            $table->boolean("url_stop_words")->default(0)->nullable();
            $table->text("url_stop_words_val")->nullable()->default("");
            $table->boolean("og_title")->default(1)->nullable();
            $table->boolean("max_og_title_length")->default(1)->nullable();
            $table->bigInteger("max_og_title_length_val")->default(95)->nullable();
            $table->boolean("min_og_title_length")->default(1)->nullable();
            $table->bigInteger("min_og_title_length_val")->default(40)->nullable();
            $table->boolean("is_og_title_equal_title")->default(0)->nullable();
            $table->boolean("og_title_casing_sentence")->default(0)->nullable();
            $table->boolean("og_title_casing_camel")->default(1)->nullable();
            $table->boolean("og_title_casing_both")->default(0)->nullable();
            $table->boolean("og_desc")->default(1)->nullable();
            $table->boolean("max_og_desc_length")->default(1)->nullable();
            $table->bigInteger("max_og_desc_length_val")->default(200)->nullable();
            $table->boolean("min_og_desc_length")->default(1)->nullable();
            $table->bigInteger("min_og_desc_length_val")->default(40)->nullable();
            $table->boolean("is_og_desc_equal_desc")->default(0)->nullable();
            $table->boolean("og_image")->default(1)->nullable();
            $table->boolean("og_image_dimensions_min")->default(0)->nullable();
            $table->bigInteger("og_image_width_min")->default(0)->nullable();
            $table->bigInteger("og_image_height_min")->default(0)->nullable();
            $table->boolean("og_image_dimensions_exact")->default(1)->nullable();
            $table->bigInteger("og_image_width_exact")->default(1200)->nullable();
            $table->bigInteger("og_image_height_exact")->default(630)->nullable();
            $table->boolean("og_url")->default(1)->nullable();
            $table->boolean("is_og_url_equal_url")->default(0)->nullable();
            $table->boolean("max_og_url_length")->default(1)->nullable();
            $table->bigInteger("max_og_url_length_val")->default(60)->nullable();
            $table->boolean("twitter_title")->default(1)->nullable();
            $table->boolean("max_twitter_title_length")->default(1)->nullable();
            $table->bigInteger("max_twitter_title_length_val")->default(70)->nullable();
            $table->boolean("min_twitter_title_length")->default(0)->nullable();
            $table->bigInteger("min_twitter_title_length_val")->default(0)->nullable();
            $table->boolean("is_twitter_title_equal_title")->default(0)->nullable();
            $table->boolean("twitter_title_casing_sentence")->default(0)->nullable();
            $table->boolean("twitter_title_casing_camel")->default(1)->nullable();
            $table->boolean("twitter_title_casing_both")->default(0)->nullable();
            $table->boolean("twitter_image")->default(1)->nullable();
            $table->boolean("twitter_image_dimensions_min")->default(0)->nullable();
            $table->bigInteger("twitter_image_width_min")->default(0)->nullable();
            $table->bigInteger("twitter_image_height_min")->default(0)->nullable();
            $table->boolean("twitter_image_dimensions_exact")->default(1)->nullable();
            $table->bigInteger("twitter_image_width_exact")->default(1200)->nullable();
            $table->bigInteger("twitter_image_height_exact")->default(675)->nullable();
            $table->boolean("twitter_image_alt")->default(1)->nullable();
            $table->boolean("max_twitter_image_alt_length")->default(1)->nullable();
            $table->bigInteger("max_twitter_image_alt_length_val")->default(400)->nullable();
            $table->boolean("favicon")->default(1)->nullable();
            $table->boolean("favicon_dimensions_min")->default(0)->nullable();
            $table->bigInteger("favicon_width_min")->default(0)->nullable();
            $table->bigInteger("favicon_height_min")->default(0)->nullable();
            $table->boolean("favicon_dimensions_exact")->default(0)->nullable();
            $table->bigInteger("favicon_width_exact")->default(0)->nullable();
            $table->bigInteger("favicon_height_exact")->default(0)->nullable();
            $table->boolean("xml_sitemap")->default(1)->nullable();
            $table->boolean("xml_sitemap_custom")->default(1)->nullable();
            $table->string("xml_sitemap_val")->default("")->nullable();
            $table->boolean("html_sitemap")->default(0)->nullable();
            $table->boolean("html_sitemap_custom")->default(1)->nullable();
            $table->string("html_sitemap_val")->default("")->nullable();

            $table->boolean("meta_viewport")->default(1)->nullable();
            $table->boolean("no_frameset")->default(1)->nullable();
            $table->boolean("doctype")->default(1)->nullable();
            $table->string("http_status_code_accepted")->default("200,301")->nullable();
            $table->boolean("page_size")->default(1)->nullable();
            $table->bigInteger("page_size_val")->default(100)->nullable();
            $table->boolean("hsts_header")->default(1)->nullable();
            $table->boolean("content_security_policy_header")->default(1);
            $table->boolean("no_nested_tables")->default(1);
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
            
            $table->boolean("robot_text_test_block_url")->default(1);

            $table->boolean("h1_heading_tag")->default(1);
            $table->boolean("h1_heading_tag_length")->default(1);
            $table->bigInteger("h1_heading_tag_length_val")->nullable();
            $table->boolean("h2_heading_tag_length")->default(1);
            $table->bigInteger("h2_heading_tag_length_val")->nullable();
            $table->boolean("h3_heading_tag_length")->default(1);
            $table->bigInteger("h3_heading_tag_length_val")->nullable();
            $table->boolean("h4_heading_tag_length")->default(1);
            $table->bigInteger("h4_heading_tag_length_val")->nullable();
            $table->boolean("h5_heading_tag_length")->default(1);
            $table->bigInteger("h5_heading_tag_length_val")->nullable();
            $table->boolean("h6_heading_tag_length")->default(1);
            $table->bigInteger("h6_heading_tag_length_val")->nullable();

            $table->boolean("broken_links")->default(1)->nullable();

            $table->boolean("is_html_compression")->default(1)->nullable();
            $table->boolean("is_css_compression")->default(1)->nullable();
            $table->boolean("is_js_compression")->default(1)->nullable();
            $table->boolean("is_gzip_compression")->default(1)->nullable();

            $table->boolean("google_insights_desktop")->default(1)->nullable();
            $table->bigInteger("google_insights_desktop_val")->default(90)->nullable();
            $table->boolean("google_insights_mobile")->default(1)->nullable();
            $table->bigInteger("google_insights_mobile_val")->default(90)->nullable();

            $table->boolean("google_performance_desktop")->default(1)->nullable();
            $table->bigInteger("google_performance_desktop_val")->default(90)->nullable();
            $table->boolean("google_performance_mobile")->default(1)->nullable();
            $table->bigInteger("google_performance_mobile_val")->default(90)->nullable();

            $table->boolean("google_best_practices_desktop")->default(1)->nullable();
            $table->bigInteger("google_best_practices_desktop_val")->default(90)->nullable();
            $table->boolean("google_best_practices_mobile")->default(1)->nullable();
            $table->bigInteger("google_best_practices_mobile_val")->default(90)->nullable();

            $table->boolean("google_accessibility_desktop")->default(1)->nullable();
            $table->bigInteger("google_accessibility_desktop_val")->default(90)->nullable();
            $table->boolean("google_accessibility_mobile")->default(1)->nullable();
            $table->bigInteger("google_accessibility_mobile_val")->default(90)->nullable();

            $table->boolean("google_seo_desktop")->default(1)->nullable();
            $table->bigInteger("google_seo_desktop_val")->default(90)->nullable();
            $table->boolean("google_seo_mobile")->default(1)->nullable();
            $table->bigInteger("google_seo_mobile_val")->default(90)->nullable();

            $table->boolean("google_lcp_desktop")->default(1)->nullable();
            $table->float("google_lcp_desktop_val")->default(2.5)->nullable();
            $table->boolean("google_lcp_mobile")->default(1)->nullable();
            $table->float("google_lcp_mobile_val")->default(2.5)->nullable();

            
            $table->boolean("google_fcp_desktop")->default(1)->nullable();
            $table->float("google_fcp_desktop_val")->default(2)->nullable();
            $table->boolean("google_fcp_mobile")->default(1)->nullable();
            $table->float("google_fcp_mobile_val")->default(2)->nullable();

            
            $table->boolean("google_cls_desktop")->default(1)->nullable();
            $table->float("google_cls_desktop_val")->default(0.1)->nullable();
            $table->boolean("google_cls_mobile")->default(1)->nullable();
            $table->float("google_cls_mobile_val")->default(0.1)->nullable();

            
            $table->boolean("google_fid_desktop")->default(1)->nullable();
            $table->float("google_fid_desktop_val")->default(100)->nullable();
            $table->boolean("google_fid_mobile")->default(1)->nullable();
            $table->float("google_fid_mobile_val")->default(100)->nullable();

            
            $table->boolean("google_tbt_desktop")->default(1)->nullable();
            $table->float("google_tbt_desktop_val")->default(300)->nullable();
            $table->boolean("google_tbt_mobile")->default(1)->nullable();
            $table->float("google_tbt_mobile_val")->default(300)->nullable();

            
            $table->boolean("google_tti_desktop")->default(1)->nullable();
            $table->float("google_tti_desktop_val")->default(4)->nullable();
            $table->boolean("google_tti_mobile")->default(1)->nullable();
            $table->float("google_tti_mobile_val")->default(4)->nullable();

            
            $table->boolean("google_speed_index_desktop")->default(1)->nullable();
            $table->float("google_speed_index_desktop_val")->default(4)->nullable();
            $table->boolean("google_speed_index_mobile")->default(1)->nullable();
            $table->float("google_speed_index_mobile_val")->default(4)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_settings_sub');
    }
}

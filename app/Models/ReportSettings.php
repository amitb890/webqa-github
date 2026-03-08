<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSettings extends Model
{
    use HasFactory;
    protected $table = 'report_settings';
    public $timestamps = true;

    protected $casts = [
        'meta_title' => 'integer',
        'meta_desc' => 'integer',
        'robots_meta' => 'integer',
        'canonical_url' => 'integer',
        'url_slug' => 'integer',
        'open_graph_tags' => 'integer',
        'twitter_tags' => 'integer',
        'favicon' => 'integer',
        'xml_sitemap' => 'integer',
        'meta_viewport' => 'integer',
        'frameset' => 'integer',
        'doctype' => 'integer',
        'http_status_code' => 'integer',
        'page_size' => 'integer',
        'hsts_header' => 'integer',
        'content_security_policy_header' => 'integer',
        'nested_tables' => 'integer',
        'x_frame_options_header' => 'integer',
        'ssl_certificate_enable' => 'integer',
        'bad_content_type' => 'integer',
        'folder_browsing_enable' => 'integer',
        'css_caching_enable' => 'integer',
        'js_caching_enable' => 'integer',
        'mobile_friendly' => 'integer',
        'is_safe_browsing' => 'integer',
        'cross_origin_links' => 'integer',
        'protocol_relative_resource' => 'integer',
        'h1_heading_tag' => 'integer',
        'robot_text_test' => 'integer',
        'broken_links' => 'integer',
        'images' => 'integer',
        'html_compression' => 'integer',
        'css_compression' => 'integer',
        'js_compression' => 'integer',
        'gzip_compression' => 'integer',
        'google_overall' => 'integer',
        'google_lighthouse' => 'integer',
        'core_web_vitals' => 'integer',
    ];

    protected $fillable = [
        'user_id',
        'meta_title',
        'meta_desc',
        'robots_meta',
        'canonical_url',
        'url_slug',
        'open_graph_tags',
        'twitter_tags',
        'favicon',
        'xml_sitemap',
        'meta_viewport',
        'frameset',
        'doctype',
        'http_status_code',
        'page_size',
        'hsts_header',
        'content_security_policy_header',
        'nested_tables',
        'x_frame_options_header',
        'ssl_certificate_enable',
        'bad_content_type',
        'folder_browsing_enable',
        'css_caching_enable',
        'js_caching_enable',
        'mobile_friendly',
        'is_safe_browsing',
        'cross_origin_links',
        'protocol_relative_resource',
        'h1_heading_tag',
        'robot_text_test',
        'broken_links',
        'images',
        'html_compression',
        'css_compression',
        'js_compression',
        'gzip_compression',
        'google_overall',
        'google_lighthouse',
        'core_web_vitals',
        'type'
    ];


    public function user() {
        return $this->belongsTo(\App\Models\User::class);
    }
}

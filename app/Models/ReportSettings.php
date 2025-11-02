<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSettings extends Model
{
    use HasFactory;
    protected $table = 'report_settings';
    public $timestamps = true;

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

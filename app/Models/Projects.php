<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{

    protected $fillable = [
        'user_id',
        'name',
        'homepage',
        'favicon',
        'landing_page_preview',
        'dashboard_show_status',
        'google_show_status',
        'recheck_type',
        'google_urls_checked_active',
    ];
    use HasFactory;

    public function urls() {
        return $this->hasMany(\App\Models\UrlsList::class);
    }

    public function ProjectTestDetails() {
        return $this->hasOne(\App\Models\ProjectTestDetails::class);
    }
}

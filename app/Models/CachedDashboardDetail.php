<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CachedDashboardDetail extends Model
{
    use HasFactory;

    protected $table = 'cached_dashboard_details';

    protected $fillable = [
        'project_id',
        'user_id',
        'widget_key',
        'widget_data_json',
    ];
}

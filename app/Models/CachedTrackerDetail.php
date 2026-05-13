<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CachedTrackerDetail extends Model
{
    use HasFactory;

    protected $table = 'cached_tracker_details';

    protected $fillable = [
        'project_id',
        'user_id',
        'url',
        'widget_key',
        'widget_data_json',
    ];
}

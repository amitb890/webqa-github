<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUiSnapshot extends Model
{
    protected $table = 'project_ui_snapshots';

    protected $fillable = [
        'project_id',
        'dashboard_test_id',
        'lighthouse_test_id',
        'payload',
    ];
}

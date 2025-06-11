<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTestDetails extends Model
{
    use HasFactory;
    protected $table = 'project_test_details';

    public function projects() {
        return $this->belongsTo(\App\Models\Projects::class);
    }

    public function projectSettings() {
        return $this->hasOne(\App\Models\projectSettings::class, 'projects_id', 'project_id');
    }
}

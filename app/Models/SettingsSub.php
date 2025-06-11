<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsSub extends Model
{
    use HasFactory;
    protected $table = 'project_settings_sub';
    public $timestamps = false;

    public function settings() {
        return $this->belongsTo(\App\Models\projectSettings::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectSettings extends Model
{
    use HasFactory;
    protected $table = 'project_settings';
    public $timestamps = false;

    public function settingsSub() {
        return $this->hasOne(\App\Models\SettingsSub::class);
    }
}

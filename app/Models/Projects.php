<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    public function urls() {
        return $this->hasMany(\App\Models\UrlsList::class);
    }

    public function ProjectTestDetails() {
        return $this->hasOne(\App\Models\ProjectTestDetails::class);
    }
}

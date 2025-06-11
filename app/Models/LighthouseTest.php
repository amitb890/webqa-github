<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LighthouseTest extends Model
{
    use HasFactory;

    protected $table = 'lighthouse_results';
    protected $fillable = ['user_id', 'project_id', 'test_id', 'urls', 'status', 'results'];
}

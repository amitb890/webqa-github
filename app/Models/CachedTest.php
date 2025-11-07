<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CachedTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_key',
        'result',
        'test_labels',
        'resultsData',
        'dataFailed',
        'dataPassed',
        'projectUrl',
        'web_app'
    ];

    protected $casts = [
        'result' => 'array',
        'resultsData' => 'array',
        'dataFailed' => 'array',
        'dataPassed' => 'array',
        // 'test_labels' => 'array', // Uncomment if you want auto-casting
    ];
} 
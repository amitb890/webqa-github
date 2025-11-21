<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LighthouseResult extends Model
{
    use HasFactory;

    protected $table = 'lighthouse_results';
    protected $fillable = [
        'test_id',
        'url',
        'strategy',
        'data',
        'status',
        'error_message',
    ];

    protected $casts = [
        'data' => 'array', // automatically decode/encode JSON
    ];

    public function test()
{
    return $this->belongsTo(LighthouseTest::class, 'test_id');
}
}

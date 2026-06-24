<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActionEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'action',
        'source',
        'status',
        'subject_type',
        'subject_id',
        'url',
        'message',
        'context',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'context' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

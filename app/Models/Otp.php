<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'user_id',
        'identifier',
        'channel',
        'purpose',
        'otp',
        'attempts',
        'max_attempts',
        'resend_count',
        'expires_at',
        'last_sent_at',
        'verified_at',
        'used_at',
        'invalidated_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'last_sent_at' => 'datetime',
        'verified_at' => 'datetime',
        'used_at' => 'datetime',
        'invalidated_at' => 'datetime',
    ];
}

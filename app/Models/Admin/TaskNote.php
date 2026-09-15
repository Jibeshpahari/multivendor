<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskNote extends Model
{
    protected $fillable = [
        'user_id',
        'topic_id',
        'title',
        'content',
        'status',
        'priority',
        'reminder_at',
    ];

    protected $casts = [
        'reminder_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function taskNoteTopic(): BelongsTo
    {
        return $this->belongsTo(TaskNoteTopic::class);
    }

}

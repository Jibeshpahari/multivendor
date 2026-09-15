<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskNoteTopic extends Model
{

    protected $fillable = [
        'user_id',
        'name',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function taskNote(): BelongsTo
    {
        return $this->belongsTo(TaskNote::class);
    }


}

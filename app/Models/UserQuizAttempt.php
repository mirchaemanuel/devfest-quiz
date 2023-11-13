<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuizAttempt extends Model
{
    protected $table = 'user_quiz_attempts';

    protected $fillable = [
        'user_id',
        'quiz_id',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];
}

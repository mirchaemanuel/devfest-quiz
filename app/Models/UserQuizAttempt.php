<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserQuizAttempt extends Pivot
{
    protected $table = 'user_quiz_attempts';

    protected $casts = [
        'completed_at' => 'datetime',
    ];
}

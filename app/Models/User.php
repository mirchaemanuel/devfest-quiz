<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable // implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'user_quiz_attempts')
            ->withTimestamps()
            ->withPivot('score', 'completed_at')
            ->orderByDesc('pivot_created_at');
    }

    protected function totalScore(): Attribute
    {
        return Attribute::make(get: function () {
            return $this->quizzes->whereNotNull('pivot.completed_at')
                ->sum('pivot.score');
        });
    }

    /**
     * Scope a query to include total score for each user.
     *
     * @param  Builder  $query
     */
    public function scopeWithTotalScore($query): Builder
    {
        return $query->addSelect([
            'total_score' => UserQuizAttempt::selectRaw('sum(score)')
                ->whereColumn('user_id', 'users.id'),
        ]);
    }
}

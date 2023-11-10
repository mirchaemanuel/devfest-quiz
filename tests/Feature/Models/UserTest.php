<?php

use App\Models\Quiz;
use App\Models\User;

it('has quizzes', function () {
    // Arrange
    $user = User::factory()->has(
        Quiz::factory()->count(3),
    )->create();

    // Act & Assert
    expect($user->quizzes)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Quiz::class);

});

describe('pivot `quizzes`', function () {
    it('has extra field score', function () {
        // Arrange
        $user = User::factory()
            ->has(Quiz::factory(), 'quizzes')
            ->create();
        $userQuizAttempt = $user->quizzes()->first()->pivot;

        // Act & Assert
        expect($userQuizAttempt)->score
            ->toBe((int)0)
            ->and($userQuizAttempt)->update(['score' => 10])
            ->and($userQuizAttempt)->score
            ->toBe(10);
    });

    it('has extra field created_at', function () {
        // Arrange
        $user = User::factory()
            ->has(Quiz::factory(), 'quizzes')
            ->create();
        $userQuizAttempt = $user->quizzes()->first()->pivot;

        // Act & Assert
        expect($userQuizAttempt)->completed_at
            ->toBeNull()
            ->and($userQuizAttempt)->update(['completed_at' => now()])
            ->and($userQuizAttempt)->completed_at
            ->toBeInstanceOf(Illuminate\Support\Carbon::class);

    });
});

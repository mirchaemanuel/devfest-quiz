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

it('has totalScore attribute', function () {
    // Arrange
    $user = User::factory()
        ->hasAttached(
            Quiz::factory()->count(2),
            ['score' => 10, 'completed_at' => now()],
            'quizzes'
        )->create();

    // Act & Assert
    expect($user)->totalScore
        ->toBe(20);

});

test('totalScore attributes contains only score from completed quizzes', function () {
    // Arrange
    $user = User::factory()
        ->hasAttached(
            Quiz::factory()->count(2),
            ['score' => 10, 'completed_at' => now()],
            'quizzes'
        )->create();
    $user->quizzes()->attach(
        Quiz::factory()->create(), ['score' => 10]
    );

    // Act & Assert
    expect($user)->totalScore
        ->toBe(20);

});

it('returns totalScore with scope withTotalScore', function () {
    // Arrange
    User::factory()
        ->hasAttached(
            Quiz::factory()->count(2),
            ['score' => 10, 'completed_at' => now()],
            'quizzes'
        )->create();

    // Act & Assert
    expect(User::withTotalScore()->first())->totalScore
        ->toBe(20);

    // Arrange
    User::factory()
        ->count(5)
        ->hasAttached(
            Quiz::factory()->count(2),
            ['score' => 10, 'completed_at' => now()],
            'quizzes'
        )->create();

    // Act & Assert
    // it works with collections too
    User::withTotalScore()->get()->each(
        fn($user) => expect($user)->totalScore->toBe(20)
    );

});

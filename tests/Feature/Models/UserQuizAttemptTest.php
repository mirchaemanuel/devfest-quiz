<?php

use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuizAttempt;

it('has score column', function () {
    // Arrange
    $user = User::factory()
        ->has(Quiz::factory(), 'quizzes')
        ->create();

    // Act & Assert
    expect(UserQuizAttempt::first()->score)
        ->toBe((int) 0)
        ->and(UserQuizAttempt::first()->update(['score' => 10]))
        ->and(UserQuizAttempt::first()->score)
        ->toBe(10);

});

it('has completed_at column', function () {
    // Arrange
    $user = User::factory()
        ->has(Quiz::factory(), 'quizzes')
        ->create();

    // Act & Assert
    expect(UserQuizAttempt::first()->completed_at)
        ->toBeNull()
        ->and(UserQuizAttempt::first()->update(['completed_at' => now()]))
        ->and(UserQuizAttempt::first()->completed_at)
        ->toBeInstanceOf(Illuminate\Support\Carbon::class);

});

it('has ID column after create', function () {
    // Arrange
    $user = User::factory()->create();
    $quiz = Quiz::factory()->create();

    $userQuizAttempt = UserQuizAttempt::create([
        'user_id' => $user->id,
        'quiz_id' => $quiz->id,
    ]);
    // Act & Assert
    expect($userQuizAttempt)->id->not->toBeNull()->toBe(1);

});

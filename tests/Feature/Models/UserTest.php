<?php

use App\Models\Quiz;
use App\Models\User;

it('has quizzes', function() {
    // Arrange
    $user = User::factory()->has(
        Quiz::factory()->count(3),
    )->create();

    // Act & Assert
    expect($user->quizzes)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Quiz::class);

 });

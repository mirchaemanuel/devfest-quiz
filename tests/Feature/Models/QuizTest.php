<?php

use App\Models\Question;
use App\Models\Quiz;

it('has questions', function() {
    // Arrange
    $quiz = Quiz::factory()->has(
        Question::factory()->count(3),
        'questions'
    )->create();

    // Act & Assert
    expect($quiz->questions)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Question::class);

 });

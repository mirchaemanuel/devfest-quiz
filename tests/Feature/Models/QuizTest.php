<?php

use App\Models\Question;
use App\Models\Quiz;

it('has questions', function () {
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

it('has title column', function () {
    // Arrange
    $quiz = Quiz::factory()->create([
        'title' => 'Test Quiz',
    ]);


    // Act & Assert
    expect($quiz->title)
        ->toBe('Test Quiz');

});

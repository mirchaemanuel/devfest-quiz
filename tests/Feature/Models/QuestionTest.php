<?php

use App\Models\Question;
use App\Models\Quiz;

it('has integer score column', function () {
    // Arrange
    $quiz = Quiz::factory()->create();
    $question = Question::factory()->create([
        'quiz_id' => $quiz->id,
        'score' => 10,
    ]);

    // Act & Assert
    expect($question->score)
        ->toBeInt()
        ->toBe(10);

});

it('has score column with default value 1', function () {
    // Arrange
    $quiz = Quiz::factory()->create();
    $question = Question::factory()->create([
        'quiz_id' => $quiz->id,
    ]);
    $question = Question::find(1);

    // Act & Assert
    expect($question->score)
        ->toBeInt()
        ->toBe(1);
});

it('has solution column with expected', function (bool $result) {
    // Arrange
    $quiz = Quiz::factory()->create();
    $question = Question::factory()->create([
        'quiz_id' => $quiz->id,
        'score' => 10,
        'solution' => $result,
    ]);

    // Act & Assert
    expect($question->solution)
        ->toBeBool()
        ->toBe($result);

})->with([true, false]);

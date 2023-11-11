<?php

use App\Models\Question;
use App\Models\Quiz;

it('has quiz name title', function () {
    // Arrange
    $quiz = Quiz::factory()->create([
        'title' => 'Test Quiz',
    ]);

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz])
        ->assertOk()
        ->assertSee($quiz->title);

});

it('has number of questions', function () {
    // Arrange
    $quiz = Quiz::factory()->has(Question::factory(10))->create();

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz])
        ->assertOk()
        ->assertSeeInOrder([
            __('Questions'),
            $quiz->questions->count(),
        ]);

});

it('has max score', function () {
    // Arrange
    $quiz = Quiz::factory()
        ->create();

    $question1 = Question::factory()->create([
        'quiz_id' => 1,
        'score' => 5,
    ]);
    $question2 = Question::factory()->create([
        'quiz_id' => 1,
        'score' => 8,
    ]);

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz])
        ->assertOk()
        ->assertSeeInOrder([
            __('Max score'),
            13,
        ]);

});

it('has play quiz link button', function () {
    // Arrange
    $quiz = Quiz::factory()
        ->has(Question::factory()->count(5))
        ->create();

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz])
        ->assertOk()
        ->assertSeeHtmlInOrder([
            '<a',
            'href="'.
            route('pages.members.quiz.show', $quiz),
            'wire:navigate',
            __('Play quiz'),
        ], false);

});

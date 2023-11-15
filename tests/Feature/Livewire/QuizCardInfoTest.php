<?php

use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;

it('has quiz property', function () {
    // Arrange
    $quiz = Quiz::factory()
        ->create();
    $user = User::factory()
        ->create();

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $user])
        ->assertOk()
        ->assertSet('quiz', $quiz);

});

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
        'score'   => 5,
    ]);
    $question2 = Question::factory()->create([
        'quiz_id' => 1,
        'score'   => 8,
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
            'href="' .
            route('pages.members.quiz.show', $quiz),
            'wire:navigate',
            __('Play quiz'),
        ], false);

});

it('has user property', function () {
    // Arrange
    $quiz = Quiz::factory()
        ->create();
    $user = User::factory()
        ->create();

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $user])
        ->assertOk()
        ->assertSet('user', $user);

});

it('set number of completed attempts property for the user', function () {
    // Arrange
    $quiz = Quiz::factory()
        ->create();
    $user = User::factory()
        ->create();
    $user->quizzes()->attach($quiz, ['completed_at' => now()]);
    $user->quizzes()->attach($quiz, ['completed_at' => now()]);
    $user->quizzes()->attach($quiz, ['completed_at' => null]);

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $user])
        ->assertOk()
        ->assertSet('totalCompletedAttempts', 2);

});

it('set total score property for completed quiz of the user', function () {
    // Arrange
    $quiz = Quiz::factory()
        ->create();
    $user = User::factory()
        ->create();

    $user->quizzes()->attach($quiz, ['completed_at' => now(), 'score' => 5]);
    $user->quizzes()->attach($quiz, ['completed_at' => now(), 'score' => 8]);
    $user->quizzes()->attach($quiz, ['completed_at' => null, 'score' => 100]);

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $user])
        ->assertOk()
        ->assertSet('totalScore', 13);

});

it('shows number of completed attempts for the user', function() {
    // Arrange
    $quiz = Quiz::factory()
        ->create();
    $user = User::factory()
        ->create();

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $user])
        ->assertOk()
        ->set('totalCompletedAttempts', 2)
        ->assertSeeHtmlInOrder([
            "<span id=\"quiz-{$quiz->id}-attempts\"",
            '2',
        ]);

 });

it('shows number of achieved score for the user', function() {
    // Arrange
    $quiz = Quiz::factory()
        ->create();
    $user = User::factory()
        ->create();

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $user])
        ->assertOk()
        ->set('totalScore', 13)
        ->assertSeeHtmlInOrder([
            "<span id=\"quiz-{$quiz->id}-score\"",
            '13',
        ]);

 });

<?php

use App\Livewire\QuizInfoCard;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('requires user property', function() {
    // Arrange
    $quiz = Quiz::factory()->create();

    // Act & Assert
    Livewire::test(QuizInfoCard::class, ['quiz' => $quiz]);

 })->throws(\Exception::class);

it('requires quiz property', function() {

    // Act & Assert
        Livewire::test(QuizInfoCard::class, ['user' => $this->user]);

})->throws(\Exception::class);

it('has quiz property', function () {
    // Arrange
    $quiz = Quiz::factory()->create();

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSet('quiz', $quiz);

});

it('has quiz name title', function () {
    // Arrange
    $quiz = Quiz::factory()->create([
        'title' => 'Test Quiz',
    ]);

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSee($quiz->title);

});

it('has number of questions', function () {
    // Arrange
    $quiz = Quiz::factory()->has(Question::factory(10))->create();

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $this->user])
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
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $this->user])
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
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $this->user])
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
    $quiz = Quiz::factory()->create();

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSet('user', $this->user);

});

it('set number of completed attempts property for the user', function () {
    // Arrange
    $quiz = Quiz::factory()->create();
    $user = $this->user;
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
    $quiz = Quiz::factory()->create();
    $user = $this->user;

    $user->quizzes()->attach($quiz, ['completed_at' => now(), 'score' => 5]);
    $user->quizzes()->attach($quiz, ['completed_at' => now(), 'score' => 8]);
    $user->quizzes()->attach($quiz, ['completed_at' => null, 'score' => 100]);

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $user])
        ->assertOk()
        ->assertSet('totalScore', 13);

});

it('set number of completed attempts property only for current quiz', function() {
     // Arrange
    $quiz = Quiz::factory()->create();
    $quiz2 = Quiz::factory()->create();
    $user = $this->user;
    $user->quizzes()->attach($quiz, ['completed_at' => now()]);
    $user->quizzes()->attach($quiz, ['completed_at' => now()]);
    $user->quizzes()->attach($quiz2, ['completed_at' => now()]);

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $user])
        ->assertOk()
        ->assertSet('totalCompletedAttempts', 2);

 });

it('set total score property only for current quiz', function() {
     // Arrange
    $quiz = Quiz::factory()->create();
    $quiz2 = Quiz::factory()->create();
    $user = $this->user;
    $user->quizzes()->attach($quiz, ['completed_at' => now(), 'score' => 5]);
    $user->quizzes()->attach($quiz, ['completed_at' => now(), 'score' => 8]);
    $user->quizzes()->attach($quiz2, ['completed_at' => now(), 'score' => 13]);

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $user])
        ->assertOk()
        ->assertSet('totalScore', 13);

 });

it('shows number of completed attempts for the user', function() {
    // Arrange
    $quiz = Quiz::factory()->create();
    $user = $this->user;

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
    $quiz = Quiz::factory()->create();
    $user = $this->user;

    // Act & Assert
    Livewire::test('quiz-info-card', ['quiz' => $quiz, 'user' => $user])
        ->assertOk()
        ->set('totalScore', 13)
        ->assertSeeHtmlInOrder([
            "<span id=\"quiz-{$quiz->id}-score\"",
            '13',
        ]);

 });

<?php

use App\Livewire\PlayQuiz;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;

beforeEach(function () {
    $this->quiz = Quiz::factory()->create();
    $this->user = User::factory()->create();
});

it('has questions section', function () {
    // Arrange

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSeeHtmlInOrder([
            '<section',
            'id="questions"',
        ], false);

});

it('has all the questions of the quiz', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id' => $this->quiz->id,
        'question' => 'Question 1',
    ]);
    $question2 = Question::factory()->create([
        'quiz_id' => $this->quiz->id,
        'question' => 'Question 2',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSee([
            $question1->question,
            $question2->question,
        ], false);

});

it('show true or false buttons besides each questions', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id' => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSeeHtmlInOrder([
            $question1->question,
            '<button',
            'wire:click="markTrue('.$question1->id.')"',
            '</button>',
            '<button',
            'wire:click="markFalse('.$question1->id.')"',
            '</button>',
        ]);

});

it('has start quiz button', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id' => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSeeHtmlInOrder([
            '<button',
            'wire:click="startQuiz"',
            __('Start quiz'),
            '</button>',
        ], false);

});

it('has true/false button disabled until quiz is not started', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id' => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSeeHtml([
            '<button wire:click="markTrue('.$question1->id.')" disabled',
            '<button wire:click="markFalse('.$question1->id.')" disabled',
        ]);

});

it('starts quiz', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id' => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->call('startQuiz')
        ->assertSet('started', true);
    expect($this->user->quizzes->whereNotNull('pivot.created_at'))->toHaveCount(1);

});

it('has click true/false button enabled when quiz has been started', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id' => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->assertDontSeeHtml([
            '<button wire:click="markTrue('.$question1->id.')" disabled',
            '<button wire:click="markFalse('.$question1->id.')" disabled',
        ]);

});

it('has start button disabled when quiz has been started', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id' => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->assertSeeHtml(
            '<button wire:click="startQuiz" disabled',
        );

});

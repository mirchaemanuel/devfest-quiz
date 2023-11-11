<?php

use App\Livewire\PlayQuiz;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuizAttempt;

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
        'quiz_id'  => $this->quiz->id,
        'question' => 'Question 1',
    ]);
    $question2 = Question::factory()->create([
        'quiz_id'  => $this->quiz->id,
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
        'quiz_id'  => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSeeHtmlInOrder([
            $question1->question,
            '<button',
            'wire:click="markTrue(' . $question1->id . ')"',
            '</button>',
            '<button',
            'wire:click="markFalse(' . $question1->id . ')"',
            '</button>',
        ]);

});

it('has start quiz button', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id'  => $this->quiz->id,
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
        'quiz_id'  => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSeeHtml([
            '<button wire:click="markTrue(' . $question1->id . ')" disabled',
            '<button wire:click="markFalse(' . $question1->id . ')" disabled',
        ]);

});

it('can start a quiz', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id'  => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->call('startQuiz')
        ->assertSet('started', true);
    expect($this->user->quizzes->whereNotNull('pivot.created_at'))->toHaveCount(1);

});

it('can terminate a quiz', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id'  => $this->quiz->id,
        'question' => 'Question 1',
    ]);
    $this->user->quizzes()->attach(
        $this->quiz,
        [
            'created_at' => now(),
        ]
    );

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->set('started', true)
        ->set('userQuizAttempt', UserQuizAttempt::first())
        ->call('terminateQuiz')
        ->assertSet('completed', true);
    expect($this->user->quizzes->whereNotNull('pivot.completed_at'))->toHaveCount(1);

});

it('cannot start a completed quiz', function() {
    // Arrange

    // Act & Assert

 });

it('cannot terminate a not started quiz', function() {
    // Arrange

    // Act & Assert

 });

it('has click true/false button enabled when quiz has been started', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id'  => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->assertDontSeeHtml([
            '<button wire:click="markTrue(' . $question1->id . ')" disabled',
            '<button wire:click="markFalse(' . $question1->id . ')" disabled',
        ]);

});

it('has not start button when quiz has been started', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id'  => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->assertDontSeeHtml(
            '<button wire:click="startQuiz"',
        );

});

it('has terminate quiz button when quiz has been started', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id'  => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->assertSeeHtmlInOrder([
                '<button wire:click="terminateQuiz"',
                __('Terminate quiz'),]
        );

});

it('has not terminate button when quiz has not been started', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id'  => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertDontSeeHtml(
            '<button wire:click="terminateQuiz"',
        );

});

it('has confirmation request on terminate button', function () {
    // Arrange
    $question1 = Question::factory()->create([
        'quiz_id'  => $this->quiz->id,
        'question' => 'Question 1',
    ]);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->assertSeeHtmlInOrder([
                '<button wire:click="terminateQuiz"',
                'wire:confirm',
                __('Terminate quiz'),]
        );


});

it('shows actual score 0 if quiz has not been started', function () {
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSeeHtmlInOrder([
            'id="quiz-summary"',
            __('Score'),
            '0',
        ], false);

});

it('shows number of answers 0 if quis has not been started', function () {
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSeeHtmlInOrder([
            'id="quiz-summary"',
            __('Answers'),
            '0',
        ], false);

});

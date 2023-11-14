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

function createQuestion(int $quizId, string $question = null, int $score = 1, bool $solution = false): Question
{
    return Question::factory()->create([
        'quiz_id' => $quizId,
        'question' => $question ?? fake()->sentence(),
        'score' => $score,
        'solution' => $solution,
    ]);
}

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
    $question1 = createQuestion($this->quiz->id);
    $question2 = createQuestion($this->quiz->id);

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
    $question1 = createQuestion($this->quiz->id);

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
    $question1 = createQuestion($this->quiz->id);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSeeHtmlInOrder([
            '<tr id="question-'.$question1->id.'"',
            '<td id="answer-true-'.$question1->id.'"',
            '<button wire:click="markTrue('.$question1->id.')"',
            'disabled="disabled"',
            '<td id="answer-false-'.$question1->id.'"',
            '<button wire:click="markFalse('.$question1->id.')"',
            'disabled="disabled"',
            '<td id="result-'.$question1->id.'"',
        ]);

});

it('has true/false buttons disabled when quiz is completed', function () {
    // Arrange
    $question1 = createQuestion($this->quiz->id);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->set('started', true)
        ->set('completed', true)
        ->assertSeeHtmlInOrder([
            '<tr id="question-'.$question1->id.'"',
            '<td id="answer-true-'.$question1->id.'"',
            '<button wire:click="markTrue('.$question1->id.')"',
            'disabled="disabled"',
            '<td id="answer-false-'.$question1->id.'"',
            '<button wire:click="markFalse('.$question1->id.')"',
            'disabled="disabled"',
            '<td id="result-'.$question1->id.'"',
        ]);

});

it('can start a quiz', function () {
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->call('startQuiz')
        ->assertSet('started', true);
    expect($this->user->quizzes->whereNotNull('pivot.created_at'))->toHaveCount(1);

});

it('can terminate a quiz', function () {
    // Arrange
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

it('cannot start if user quiz attempt is not null', function() {
    // Arrange
    $this->user->quizzes()->attach(
        $this->quiz,
        [
            'created_at' => now(),
            'completed_at' => now(),
        ]
    );
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->set('userQuizAttempt', UserQuizAttempt::first())
        ->call('startQuiz')
        ->assertSet('started', false);

 });

it('cannot start a completed quiz', function () {
    // Arrange
    $this->user->quizzes()->attach(
        $this->quiz,
        [
            'created_at' => now(),
            'completed_at' => now(),
        ]
    );

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->set('started', true)
        ->set('completed', true)
        ->call('startQuiz')
        ->assertSet('started', true)
        ->assertSet('completed', true);
});

it('cannot terminate a not started quiz', function () {
    // Arrange
    $this->user->quizzes()->attach(
        $this->quiz,
        [
            'created_at' => now(),
        ]
    );

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->set('started', false)
        ->call('terminateQuiz')
        ->assertSet('started', false)
        ->assertSet('completed', false);
    expect(UserQuizAttempt::first())->completed_at->toBeNull();

});

it('has click true/false button enabled when quiz has been started', function () {
    // Arrange
    $question1 = createQuestion($this->quiz->id);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->assertDontSeeHtml([
            '<button wire:click="markTrue('.$question1->id.')" disabled',
            '<button wire:click="markFalse('.$question1->id.')" disabled',
        ]);

});

it('has not start button when quiz has been started', function () {
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->set('started', true)
        ->assertDontSeeHtml(
            '<button wire:click="startQuiz"',
        );

});

it('has not terminate quiz button when quiz has been completed', function () {
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->set('started', true)
        ->set('completed', true)
        ->assertDontSeeHtml(
            '<button wire:click="terminateQuiz"',
        );

});

it('has go back to dashbaord button when quiz has been completed', function () {
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->set('started', true)
        ->set('completed', true)
        ->assertSeeHtmlInOrder([
            '<a',
            'href="'.route('pages.members.dashboard').'"',
            'wire:navigate',
            __('Back to dashboard'),
        ]);

});

it('has terminate quiz button when quiz has been started', function () {
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->assertSeeHtmlInOrder([
            '<button wire:click="terminateQuiz"',
            __('Terminate quiz'), ]
        );

});

it('has not terminate button when quiz has not been started', function () {
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertDontSeeHtml(
            '<button wire:click="terminateQuiz"',
        );

});

it('has confirmation request on terminate button', function () {
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->assertSeeHtmlInOrder([
            '<button wire:click="terminateQuiz"',
            'wire:confirm',
            __('Terminate quiz'), ]
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

it('marks question answered true with markTrue', function () {
    // Arrange
    $question = createQuestion($this->quiz->id);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->call('markTrue', $question->id)
        ->assertSet('answers', [
            $question->id => true,
        ]);

});

it('marks question answered false with markFalse', function () {
    // Arrange
    $question = createQuestion($this->quiz->id);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->call('markFalse', $question->id)
        ->assertSet('answers', [
            $question->id => false,
        ]);

});

it('disables true/false buttons for answered question', function (string $markAction) {
    // Arrange
    $question = createQuestion($this->quiz->id);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->call($markAction, $question->id)
        ->assertSeeHtmlInOrder([
            '<tr id="question-'.$question->id.'"',
            '<td id="answer-true-'.$question->id.'"',
            '<button wire:click="markTrue('.$question->id.')"',
            'disabled="disabled"',
            '<td id="answer-false-'.$question->id.'"',
            '<button wire:click="markFalse('.$question->id.')"',
            'disabled="disabled"',
            '<td id="result-'.$question->id.'"',
        ]);

})->with([
    'markTrue', 'markFalse',
]);

it('show expected question result for wrong answered question', function (bool $solution, string $markAction) {
    // Arrange
    $question = createQuestion($this->quiz->id, solution: $solution);

    // Act & Assert
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->call($markAction, $question->id)
        ->assertSeeHtmlInOrder([
            '<tr id="question-'.$question->id.'"',
            '<td id="result-'.$question->id.'"',
            '<span',
            __('Incorrect'),
            '</tr>',

        ]);

})->with([
    [true, 'markFalse'],
    [false, 'markTrue'],
]);

it('show expected question result for correct answered question', function (bool $solution, string $markAction) {
    // Arrange
    $question = createQuestion($this->quiz->id, solution: $solution);

    // Act & Assert
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->call($markAction, $question->id)
        ->assertSeeHtmlInOrder([
            '<tr id="question-'.$question->id.'"',
            '<td id="result-'.$question->id.'"',
            '<span',
            __('Correct'),
            '</tr>',

        ]);

})->with([
    [true, 'markTrue'],
    [false, 'markFalse'],
]);

describe('score', function () {
    it('is 0 when the quiz has not been started', function () {
        // Arrange
        $question = createQuestion($this->quiz->id, score: 2, solution: true);

        // Act & Assert
        Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
            ->assertOk()
            ->assertSet('score', 0);

    });

    it('increments when a correct answer has been placed', function (bool $answer, string $action) {
        // Arrange
        $expectedScore = 2;
        $question = createQuestion($this->quiz->id, score: $expectedScore, solution: $answer);

        // Act & Assert
        Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
            ->assertOk()
            ->assertSet('score', 0)
            ->call('startQuiz')
            ->call($action, $question->id)
            ->assertSet('score', $expectedScore);

    })->with(
        [
            [true, 'markTrue'],
            [false, 'markFalse'],
        ]
    );
});

describe('totalAnswers', function () {
    it('is 0 when the quiz has not been started', function () {
        // Arrange
        $question = createQuestion($this->quiz->id, score: 2, solution: true);

        // Act & Assert
        Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
            ->assertOk()
            ->assertSet('totalAnswers', 0);

    });

    it('increments when a correct answer has been placed', function (string $action) {
        // Arrange
        $question1 = createQuestion($this->quiz->id);
        $question2 = createQuestion($this->quiz->id);

        // Act & Assert
        Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
            ->assertOk()
            ->call('startQuiz')
            ->call($action, $question1->id)
            ->call($action, $question2->id)
            ->assertSet('totalAnswers', 2);

    })->with(
        [
            'markTrue',
            'markFalse',
        ]
    );
});

it('shows maxScore value', function () {
    // Arrange
    $question1 = createQuestion($this->quiz->id, score: 13);
    $question2 = createQuestion($this->quiz->id, score: 19);

    $maxScore = $question1->score + $question2->score;

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSeeHtmlInOrder([
            '<span id="score-max">',
            $maxScore,
            '</span>',
        ]);

});

it('completes quiz when all questions has been answered', function () {
    // Arrange
    $question1 = createQuestion($this->quiz->id);
    $question2 = createQuestion($this->quiz->id);
    $question3 = createQuestion($this->quiz->id);

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->call('startQuiz')
        ->call('markTrue', $question1->id)
        ->call('markTrue', $question2->id)
        ->call('markTrue', $question3->id)
        ->assertSet('completed', true);

});

it('adds completed_at date to quiz with terminate function', function () {
    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->call('startQuiz')
        ->call('terminateQuiz');

    expect(User::find($this->user->id)->quizzes()->first()->pivot)->completed_at->not->toBeNull();

});

it('increments score on pivot table when quiz has been completed', function () {
    // Arrange
    $question1 = createQuestion($this->quiz->id, score: 3, solution: true);
    $question2 = createQuestion($this->quiz->id, score: 7, solution: true);
    $question3 = createQuestion($this->quiz->id, score: 11, solution: true);

    $expectedScore = $question1->score + $question2->score + $question3->score;

    // Act & Assert
    Livewire::test(PlayQuiz::class, ['quiz' => $this->quiz, 'user' => $this->user])
        ->assertOk()
        ->assertSet('score', 0)
        ->call('startQuiz')
        ->call('markTrue', $question1->id)
        ->call('markTrue', $question2->id)
        ->call('markTrue', $question3->id)
        ->assertSet('completed', true);

    expect(User::find($this->user->id)->quizzes()->first()->pivot)->score->toBe($expectedScore);

});

<?php

use App\Livewire\QuizInfoCard;
use App\Models\Quiz;
use App\Models\User;

use function Pest\Laravel\get;

beforeEach(fn () => loginAsUser());

it('has the user result section', function () {
    // Act & Assert
    get(route('pages.members.dashboard'))
        ->assertOk()
        ->assertSeeInOrder([
            '<section',
            'id="user-statistics"',
            '<h1',
            __('Your statistics'),
            '</h1>',
        ], false);
});

describe('user statistics section', function () {
    it('has name of the user', function () {
        // Act & Assert
        get(route('pages.members.dashboard'))
            ->assertOk()
            ->assertSeeInOrder([
                '<h2',
                auth()->user()->name,
                '</h2>',
            ], false);

    });
    it('has quiz attempts', function () {
        // Arrange
        $user = User::first();
        $quizzes = Quiz::factory()->count(3)->create();
        $user->quizzes()->attach($quizzes->pluck('id'), ['score' => 10, 'completed_at' => now()]);
        $user->quizzes()->attach($quizzes->first()->pluck('id'), ['score' => 20]);

        // Act & Assert
        get(route('pages.members.dashboard'))
            ->assertOk()
            ->assertSeeInOrder([
                __('Quiz attempts: :count', ['count' => 3]),
            ], false);
    });
    it('has last quiz attempts', function () {
        // Arrange
        $user = User::first();
        Quiz::factory()->count(3)->create();
        $user->quizzes()->attach(1, ['score' => 10, 'completed_at' => now()->subDays(10)]);
        $user->quizzes()->attach(2, ['score' => 20, 'completed_at' => now()->subDays(5)]);
        $user->quizzes()->attach(3, ['score' => 30, 'completed_at' => now()]);

        $lastQuizAttempt = $user->quizzes->whereNotNull('pivot.completed_at')->sortByDesc('pivot.completed_at')->first();

        // Act & Assert
        get(route('pages.members.dashboard'))
            ->assertOk()
            ->assertSeeInOrder([
                __('Last quiz attempt: :date', ['date' => $lastQuizAttempt->pivot->completed_at]),
            ], false);

    });
    it('has total score', function () {
        // Arrange
        $user = User::first();
        $quizzes = Quiz::factory()->count(3)->create();
        $user->quizzes()->attach($quizzes->pluck('id'), ['score' => 10, 'completed_at' => now()]);

        // Act & Assert
        get(route('pages.members.dashboard'))
            ->assertOk()
            ->assertSeeInOrder([
                __('Total score: :score', ['score' => 30]),
            ], false);

    });
});

it('has quizzes section', function () {
    // Act & Assert
    get(route('pages.members.dashboard'))
        ->assertOk()
        ->assertSeeInOrder([
            '<section',
            'id="quizzes"',
            '<h1',
            __('Quizzes'),
            '</h1>',
        ], false);

});

describe('quizzes section', function () {
    it('has a quiz info card component for each quizzes', function () {
        // Arrange
        $quizzes = Quiz::factory()->count(3)->create();

        // Act & Assert
        get(route('pages.members.dashboard'))
            ->assertSeeLivewire(QuizInfoCard::class, ['quiz' => $quizzes->get(0)])
            ->assertSeeLivewire(QuizInfoCard::class, ['quiz' => $quizzes->get(1)])
            ->assertSeeLivewire(QuizInfoCard::class, ['quiz' => $quizzes->get(2)]);

    });
});

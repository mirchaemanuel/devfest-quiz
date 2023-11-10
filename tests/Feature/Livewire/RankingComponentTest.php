<?php

use App\Livewire\Ranking;
use App\Models\Quiz;
use App\Models\User;

it('shows list of 10 users with highest score', function () {
    // Arrange
    // each user has taken the same one quiz
    $users = User::factory()->count(20)->create();
    $quizzes = Quiz::factory()->count(1)->create();
    $users->each(
        fn($user) => $user->quizzes()->attach($quizzes->pluck('id'))
    );

    // let's arrange the ranking for 12 users
    $scores = [100, 90, 80, 70, 60, 50, 40, 30, 20, 10, 5, 4];
    $users->take(12)->each(function (User $user, int $index) use ($scores) {
        $user->quizzes()->first()->pivot->update([
            'score'      => $scores[$index],
            'created_at' => now(),
        ]);
    });

    // Act & Assert
    Livewire::test(Ranking::class)
        ->assertSeeInOrder([
            $users->get(0)->name,
            '100',
            $users->get(1)->name,
            '90',
            $users->get(2)->name,
            '80',
            $users->get(3)->name,
            '70',
            $users->get(4)->name,
            '60',
            $users->get(5)->name,
            '50',
            $users->get(6)->name,
            '40',
            $users->get(7)->name,
            '30',
            $users->get(8)->name,
            '20',
            $users->get(9)->name,
            '10',
        ])
        ->assertDontSeeHtml([
            $users->get(10)->name,
            '5',
            $users->get(11)->name,
            '4',
        ])
    ;
});

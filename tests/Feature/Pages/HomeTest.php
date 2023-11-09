<?php

use App\Models\Quiz;
use App\Models\User;

use function Pest\Laravel\get;

it('shows welcome section', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeInOrder([
            '<section',
            'id="welcome"',
            '<h2',
            __('GDG Pescara - DevFest Quiz'),
            '</h2>',
        ], false);

});

it('shows total of users in welcome section', function () {
    // Arrange
    $users = User::factory()->count(7)->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeInOrder([
            '<section',
            'id="welcome"',
            __('Users :count', ['count' => $users->count()]),
        ], false);

});

it('shows total of quizzes in welcome section', function () {
    // Arrange
    $quizzes = Quiz::factory()->count(7)->create();

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeInOrder([
            '<section',
            'id="welcome"',
            __('Quizzes :count', ['count' => $quizzes->count()]),
        ], false);

});

it('shows of total of quizzes taken in welcome section', function () {
    // Arrange
    $quizzes = Quiz::factory()->count(3)->create();
    User::factory()->count(4)->create()
        ->each(
            fn ($user) => $user->quizzes()->attach($quizzes->pluck('id'))
        );

    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeInOrder([
            '<section',
            'id="welcome"',
            __('Quiz attempts :count', ['count' => 12]),
        ], false);

});

it('shows ranking section', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeInOrder([
            '<section',
            'id="ranking"',
            '<h2',
            __('Ranking'),
            '</h2>',
        ], false);

});

it('shows ranking component', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeLivewire('ranking');
});

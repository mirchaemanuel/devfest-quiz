<?php

use App\Models\Quiz;

use function Pest\Laravel\get;

it('gives back successful response for home page', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk();

});

it('gives successful response to logged user for dashboard page', function () {
    // Arrange
    loginAsUser();

    // Act & Assert
    get(route('pages.members.dashboard'))
        ->assertOk();

});

it('gives redirect to login for dashboard page when not logged', function () {
    // Act & Assert
    get(route('pages.members.dashboard'))
        ->assertRedirect(route('login'));

});

it('gives successful response to logged user for quiz show page', function () {
    // Arrange
    loginAsUser();
    $quiz = Quiz::factory()->create();

    // Act & Assert
    get(route('pages.members.quiz.show', $quiz))
        ->assertOk();

});

it('gives redirect to login for quiz show page when not logged', function () {
    $quiz = Quiz::factory()->create();

    // Act & Assert
    get(route('pages.members.quiz.show', $quiz))
        ->assertRedirect(route('login'));

});

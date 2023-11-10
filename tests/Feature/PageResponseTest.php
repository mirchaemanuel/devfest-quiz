<?php

use function Pest\Laravel\get;

it('gives back successful response for home page', function () {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk();

});

it('gives successful response to logged user for dashboard page', function() {
    // Arrange
    loginAsUser();

    // Act & Assert
    get(route('pages.members.dashboard'))
        ->assertOk();

 });

it('gives redirect to login for dashboard page when not logged', function() {
    // Act & Assert
    get(route('pages.members.dashboard'))
        ->assertRedirect(route('login'));

 });

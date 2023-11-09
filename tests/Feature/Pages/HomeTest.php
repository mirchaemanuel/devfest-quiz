<?php

use function Pest\Laravel\get;

it('shows welcome section', function() {
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

it('shows ranking section', function() {
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

it('shows ranking component', function() {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk()
        ->assertSeeLivewire('ranking');
 });

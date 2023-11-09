<?php

use function Pest\Laravel\get;

it('shows welcome component', function() {
    // Act & Assert
    get(route('pages.home'))
        ->assertSeeLivewire('home.welcome');

 });

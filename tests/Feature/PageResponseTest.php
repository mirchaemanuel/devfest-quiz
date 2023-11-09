<?php

use function Pest\Laravel\get;

it('gives back successful response for home page', function() {
    // Act & Assert
    get(route('pages.home'))
        ->assertOk();

 });

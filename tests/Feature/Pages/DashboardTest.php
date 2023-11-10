<?php

use function Pest\Laravel\get;

beforeEach(fn() => loginAsUser());

it('has the user result section', function() {
    // Act & Assert
     get(route('pages.members.dashboard'))
        ->assertOk()
        ->assertSeeInOrder([
            '<section',
            'id="result"',
            '<h2',
            __('Your statistics'),
            '</h2>',
        ], false);
 });

describe('result section', function () {
    it('has name of the user', function() {
        // Arrange

        // Act & Assert

     });
    it('has quiz attempts', function() {
        // Arrange

        // Act & Assert

     });
    it('has last quiz attempts', function() {
        // Arrange

        // Act & Assert

     });
    it('has total score', function() {
        // Arrange

        // Act & Assert

     });
});

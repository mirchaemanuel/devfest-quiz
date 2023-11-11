<?php

use App\Models\Quiz;

use function Pest\Laravel\get;

beforeEach(function () {
    loginAsUser();
    $this->quiz = Quiz::factory()->create();
});

it('has instruction section', function () {
    // Act & Assert
    get(route('pages.members.quiz.show', $this->quiz))
        ->assertOk()
        ->assertSeeInOrder([
            '<section',
            'id="instructions"',
            '<h1',
            __('Instructions'),
            '</h1>',
        ], false);
});

it('has PlayQuiz component', function () {
    // Act & Assert
    get(route('pages.members.quiz.show', $this->quiz))
        ->assertOk()
        ->assertSeeLivewire('play-quiz');

});

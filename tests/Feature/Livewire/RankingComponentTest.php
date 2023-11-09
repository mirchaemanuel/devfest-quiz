<?php

use App\Livewire\Ranking;
use App\Models\User;

it('shows the total of users', function () {
    // Arrange
    $users = User::factory()->count(3)->create();

    // Act & Assert
    Livewire::test(Ranking::class)
        ->assertSeeTextInOrder([
            __('Users'),
            $users->count()]
        );

});

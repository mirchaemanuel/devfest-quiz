<?php

use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuizAttempt;

it('adds testing quiz', function() {
    //Assert
    $this->assertDatabaseCount(Quiz::class, 0);

    // Arrange
    $this->artisan('db:seed');

    // Act & Assert
    $this->assertDatabaseCount(Quiz::class, 10);

 });

it('adds testing user', function() {
    //Assert
    $this->assertDatabaseCount(User::class, 0);

    // Arrange
    $this->artisan('db:seed');

    // Act & Assert
    $this->assertDatabaseCount(User::class, 10);

 });

it('adds testing quiz attempts', function() {
    //Assert
    $this->assertDatabaseCount(UserQuizAttempt::class, 0);

    // Arrange
    $this->artisan('db:seed');

    // Act & Assert
    $this->assertDatabaseCount(UserQuizAttempt::class, 20);

 });

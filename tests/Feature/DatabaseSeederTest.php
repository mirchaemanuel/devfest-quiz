<?php

use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuizAttempt;

it('adds testing quizzes', function () {
    //Assert
    $this->assertDatabaseCount(Quiz::class, 0);

    // Arrange
    $this->artisan('db:seed');

    // Act & Assert
    $this->assertDatabaseCount(Quiz::class, 10);

});

it('adds testing quizzes only once', function () {
    //Assert
    $this->assertDatabaseCount(Quiz::class, 0);

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(Quiz::class, 10);

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(Quiz::class, 10);

});

it('adds testing users', function () {
    //Assert
    $this->assertDatabaseCount(User::class, 0);

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(User::class, 10);

});

it('adds testing users only once', function () {
    //Assert
    $this->assertDatabaseCount(User::class, 0);

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(User::class, 10);

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(User::class, 10);

});

it('adds testing users only on test and local environment', function() {
    // Arrange
    App::partialMock()->shouldReceive('environment')->andReturn('production');

     //Assert
    $this->assertDatabaseCount(User::class, 0);

    // Act
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(User::class, 0);

 });

it('adds testing quiz attempts', function () {
    //Assert
    $this->assertDatabaseCount(UserQuizAttempt::class, 0);

    // Act
    $this->artisan('db:seed');

    //  Assert
    $this->assertDatabaseCount(UserQuizAttempt::class, 20);

});

it('adds testing quiz attempts only once', function () {
    //Assert
    $this->assertDatabaseCount(UserQuizAttempt::class, 0);

    // Act
    $this->artisan('db:seed');

    //  Assert
    $this->assertDatabaseCount(UserQuizAttempt::class, 20);

    // Act
    $this->artisan('db:seed');

    //  Assert
    $this->assertDatabaseCount(UserQuizAttempt::class, 20);
});

it('adds testing quiz attempts only on local and test environment', function () {
    // Arrange
    App::partialMock()->shouldReceive('environment')->andReturn('production');

    //Assert
    $this->assertDatabaseCount(UserQuizAttempt::class, 0);

    // Act
    $this->artisan('db:seed');

    //  Assert
    $this->assertDatabaseCount(UserQuizAttempt::class, 0);

});

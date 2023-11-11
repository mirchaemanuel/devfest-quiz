<?php

use App\Models\Quiz;
use App\Models\User;

beforeEach(function () {
    $this->quiz = Quiz::factory()->create();
    $this->user = User::factory()->create();
});

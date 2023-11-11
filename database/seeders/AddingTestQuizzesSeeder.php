<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class AddingTestQuizzesSeeder extends Seeder
{
    public function run()
    {

        Quiz::factory()
            ->has(Question::factory()->count(5))
            ->count(10)->create();
    }
}

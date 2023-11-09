<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Seeder;

class AddingTestQuizzesSeeder extends Seeder
{
    public function run()
    {
        Quiz::factory()->count(10)->create();
    }
}

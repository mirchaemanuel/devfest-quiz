<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddingTestQuizAttemptsSeeder extends Seeder
{
    public function run()
    {
        if (User::count() === 0) {
            $this->call(AddingTestUsersSeeder::class);
        }
        if (Quiz::count() === 0) {
            $this->call(AddingTestQuizzesSeeder::class);
        }
        $quizzes = Quiz::select('id')->inRandomOrder()->get();
        User::all()->each(function (User $user) use ($quizzes) {
            $user->quizzes()->attach($quizzes->random(2)->pluck('id')->toArray(),
                [
                    'score' => rand(0, 100),
                    'completed_at' => now()->subDays(rand(0, 30)),
                ]);
        });

    }
}

<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuizAttempt;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class AddingTestQuizAttemptsSeeder extends Seeder
{
    public function run()
    {
        if (in_array(App::environment(), ['local', 'testing']) && UserQuizAttempt::count() === 0) {

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
}

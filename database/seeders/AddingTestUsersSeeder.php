<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class AddingTestUsersSeeder extends Seeder
{
    public function run()
    {
        if (in_array(App::environment(), ['local', 'testing'])) {
            if (! User::where('email', 'a@a')->exists()) {
                $user = User::factory()->create([
                    'name' => 'Test User',
                    'email' => 'a@a',
                    'password' => bcrypt('password'),
                ]);
            }
            if (User::count() > 1) {
                return;
            }
            User::factory()->count(9)->create();
        }

    }
}

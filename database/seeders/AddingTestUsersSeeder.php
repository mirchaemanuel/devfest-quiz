<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AddingTestUsersSeeder extends Seeder
{
    public function run()
    {
        if(! User::where('email', 'a@a')->exists()) {
            $user = User::factory()->create([
                'name'     => 'Test User',
                'email'    => 'a@a',
                'password' => bcrypt('password'),
            ]);
        }
        if (User::count() > 1) {
            return;
        }
        User::factory()->count(9)->create();
    }
}

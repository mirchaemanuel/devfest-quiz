<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AddingTestUsersSeeder extends Seeder
{
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'a@a',
            'password' => bcrypt('password'),
        ]);

        User::factory()->count(9)->create();
    }
}

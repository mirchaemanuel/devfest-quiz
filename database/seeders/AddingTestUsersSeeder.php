<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AddingTestUsersSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(10)->create();
    }
}

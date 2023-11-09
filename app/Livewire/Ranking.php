<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Ranking extends Component
{

    public function render()
    {
        $users = User::all();
        return view('livewire.ranking', compact('users'));
    }
}

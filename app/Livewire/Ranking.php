<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Ranking extends Component
{
    public function render()
    {
        $scoredUsers = User::with('quizzes')
            ->orderByDesc('score')
            ->get();

        return view('livewire.ranking');
    }
}

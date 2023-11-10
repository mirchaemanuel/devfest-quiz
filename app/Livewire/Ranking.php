<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Ranking extends Component
{
    public function render()
    {

        $results = User::withTotalScore()
            ->orderBy('total_score', 'desc')
            ->limit(10)
            ->get();

        return view('livewire.ranking', compact('results'));
    }
}

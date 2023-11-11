<?php

namespace App\Livewire;

use App\Models\Quiz;
use App\Models\User;
use Livewire\Component;

class PlayQuiz extends Component
{
    public Quiz $quiz;

    public User $user;

    public function render()
    {
        return view('livewire.play-quiz');
    }
}

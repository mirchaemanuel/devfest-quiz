<?php

namespace App\Livewire;

use App\Models\Quiz;
use Livewire\Component;

class QuizInfoCard extends Component
{
    public Quiz $quiz;

    public function render()
    {
        return view('livewire.quiz-info-card');
    }
}

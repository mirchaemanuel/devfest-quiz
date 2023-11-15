<?php

namespace App\Livewire;

use App\Models\Quiz;
use App\Models\User;
use Livewire\Component;

class QuizInfoCard extends Component
{
    public Quiz $quiz;

    public User $user;
    public int $totalCompletedAttempts;
    public int $totalScore;

    public function mount(Quiz $quiz, User $user)
    {
        $this->quiz = $quiz;
        $this->user = $user;

        $completedUserQuizAttempts = $this->user->quizzes->whereNotNull('pivot.completed_at');

        $this->totalCompletedAttempts = $completedUserQuizAttempts->count();
        $this->totalScore = $completedUserQuizAttempts->sum('pivot.score');

    }

    public function render()
    {
        return view('livewire.quiz-info-card');
    }
}

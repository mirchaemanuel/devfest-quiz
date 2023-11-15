<?php

namespace App\Livewire;

use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuizAttempt;
use InvalidArgumentException;
use Livewire\Component;

class QuizInfoCard extends Component
{
    public Quiz $quiz;

    public User $user;
    public int $totalCompletedAttempts;
    public int $totalScore;

    public function mount(Quiz $quiz, User $user)
    {
        if (is_null($user?->id)) {
            throw new InvalidArgumentException('User is required');
        }
        if(is_null($quiz?->id)) {
            throw new InvalidArgumentException('Quiz is required');
        }

        $this->quiz = $quiz;
        $this->user = $user;

        $completedUserQuizAttempts = UserQuizAttempt::whereQuizId($this->quiz->id)->whereUserId($this->user->id)->whereNotNull('completed_at')->get();

        $this->totalCompletedAttempts = $completedUserQuizAttempts->count();
        $this->totalScore = $completedUserQuizAttempts->sum('score');
    }

    public function render()
    {
        return view('livewire.quiz-info-card');
    }
}

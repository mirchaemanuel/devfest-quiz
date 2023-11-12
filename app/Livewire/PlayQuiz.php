<?php

namespace App\Livewire;

use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuizAttempt;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class PlayQuiz extends Component
{
    public Quiz $quiz;

    public Collection $questions;

    public User $user;

    public ?UserQuizAttempt $userQuizAttempt = null;

    public bool $started = false;

    public bool $completed = false;

    public int $score = 0;

    public int $totalAnswers = 0;

    /**
     * @var array  [question_id => answer] answered questions
     */
    public array $answers = [];

    public function mount()
    {
        $this->questions = $this->quiz->questions()->inRandomOrder(microtime())->get();
    }

    public function markTrue(int $questionId)
    {
        $this->answers[$questionId] = true;
    }

    public function markFalse(int $questionId)
    {
        $this->answers[$questionId] = false;
    }

    public function startQuiz(): void
    {
        if ($this->userQuizAttempt !== null) {
            //quiz already started
            return;
        }
        $this->userQuizAttempt = UserQuizAttempt::create([
            'user_id' => $this->user->id,
            'quiz_id' => $this->quiz->id,
        ]);
        $this->started = true;
    }

    public function terminateQuiz(): void
    {
        if ($this->userQuizAttempt !== null && $this->started && ! $this->completed) {
            $this->userQuizAttempt->update([
                'completed_at' => now(),
            ]);
            $this->completed = true;
        }
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.play-quiz');
    }
}

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

    public bool $started = false;

    public bool $completed = false;

    public int $score = 0;

    public int $maxScore = 0;

    public int $totalAnswers = 0;

    /**
     * @var array  [question_id => answer] answered questions
     */
    public array $answers = [];

    public ?UserQuizAttempt $userQuizAttempt = null;

    public function mount()
    {
        $this->questions = $this->quiz->questions()->orderBy('id')->get();
        $this->maxScore = $this->questions->sum('score');
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
        if ($this->userQuizAttempt !== null && $this->started && !$this->completed) {
            $this->userQuizAttempt->completed_at = now();
            $this->userQuizAttempt->score = $this->score;
            $this->userQuizAttempt->save();

            $this->completed = true;
        }
    }

    private function answerQuestion(int $questionId, bool $answer): void
    {
        $this->answers[$questionId] = $answer;
        $this->totalAnswers++;
        $question = $this->questions->find($questionId);
        if ($question->solution === $answer) {
            $this->score += $question->score;
        }
        if ($this->totalAnswers === $this->questions->count()) {
            $this->terminateQuiz();
        }
    }

    public function markTrue(int $questionId): void
    {
        $this->answerQuestion($questionId, true);
    }

    public function markFalse(int $questionId): void
    {
        $this->answerQuestion($questionId, false);
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.play-quiz');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;

class PageDashboardController extends Controller
{
    public function index()
    {
        $user = User::withTotalScore()->find(auth()->user()->id);
        $totalCompletedQuizzes = $user->quizzes->whereNotNull('pivot.completed_at')->count();
        $lastQuizAttemptDate = $user->quizzes->whereNotNull('pivot.completed_at')->sortByDesc('pivot.completed_at')->first()?->pivot?->completed_at;
        $totalScore = $user->totalScore;
        $quizzes = Quiz::all();

        return view('pages.members.dashboard',
            compact('totalCompletedQuizzes', 'lastQuizAttemptDate', 'quizzes', 'totalScore'));
    }
}

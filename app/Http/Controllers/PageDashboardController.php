<?php

namespace App\Http\Controllers;

use App\Models\Quiz;

class PageDashboardController extends Controller
{
    public function index()
    {
        $totalCompletedQuizzes = auth()->user()->quizzes->whereNotNull('pivot.completed_at')->count();
        $lastQuizAttemptDate = auth()->user()->quizzes->whereNotNull('pivot.completed_at')->sortByDesc('pivot.completed_at')->first()?->pivot?->completed_at;
        $quizzes = Quiz::all();

        return view('pages.members.dashboard',
            compact('totalCompletedQuizzes', 'lastQuizAttemptDate', 'quizzes'));
    }
}

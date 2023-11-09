<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\UserQuizAttempt;

class PageHomeController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalQuizzes = Quiz::count();
        $totalQuizAttempts = UserQuizAttempt::count();

        return view('pages.home', compact('totalUsers', 'totalQuizzes', 'totalQuizAttempts'));

    }
}

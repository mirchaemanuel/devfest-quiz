<?php

namespace App\Http\Controllers;

use App\Models\User;

class PageHomeController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        return view('pages.home', compact('totalUsers'));

    }
}

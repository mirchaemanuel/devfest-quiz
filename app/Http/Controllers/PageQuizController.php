<?php

namespace App\Http\Controllers;

use App\Models\Quiz;

class PageQuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        return 'pippo';
    }
}

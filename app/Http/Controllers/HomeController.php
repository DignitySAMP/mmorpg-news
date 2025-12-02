<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request) {

        return Inertia::render('Welcome', [
            'articles' => Article::with(['user', 'comments', 'images'])->get()->append(['similar_articles', 'read_time'])
        ]);
    }
}

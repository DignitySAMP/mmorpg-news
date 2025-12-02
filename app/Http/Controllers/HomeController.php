<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request) {

        // TODO: add filter for article
        /*

            - newest to oldest
            - oldest to newest
            - author
            - title
            - text

            TODO: add article tags
            -> make it so these are dynamically created, appended or deleted if no articles are using them

        */

        return Inertia::render('Welcome', [
            'articles' => Article::with(['user', 'comments', 'images'])->get()->append(['similar_articles', 'read_time'])
        ]);
    }
}

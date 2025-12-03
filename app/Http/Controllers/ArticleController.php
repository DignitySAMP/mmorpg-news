<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

require base_path('app/Http/Controllers/_ArticleControllerUtils.php');

class ArticleController extends Controller
{
    /*
        TODO: add article tags
        -> make it so these are dynamically created, appended or deleted if no articles are using them
    */

    public function index(Request $request): Response
    {
        // filter variables
        $sortBy = $request->input('sort_by', 'newest');
        $perPage = $request->input('per_page', 15);
        $search = $request->input('search', '');

        // eager load all relationships, make sure to only load necessary variables
        $query = Article::query()
            ->with([ 'user:id,name,email' ])  // user relation
            ->withCount('comments'); // only add full comment count 

        // apply search text and sorting parameters
        if ($search) $query = applySearch($query, $search);
        $query = applySorting($query, $sortBy);
        $articles = $query->paginate($perPage); // paginate current collection after search queries

        // calculate read_time on collection (so we skip a DB query: for performance)
        $articles->getCollection()->transform(function ($article) {
            $article->read_time = calculateReadTime($article->content);
            return $article;
        });

        return Inertia::render('Welcome', [
            'articles' => $articles,
            'filters' => [
                'sort_by' => $sortBy,
                'per_page' => $perPage,
                'search' => $search
            ],
            'sort_options' => [
                ['value' => 'newest', 'label' => 'Newest First'],
                ['value' => 'oldest', 'label' => 'Oldest First'],
                ['value' => 'title_asc', 'label' => 'Title (A-Z)'],
                ['value' => 'title_desc', 'label' => 'Title (Z-A)'],
                ['value' => 'author', 'label' => 'Author Name'],
                ['value' => 'most_commented', 'label' => 'Most Discussed'],
                ['value' => 'read_time_short', 'label' => 'Quick Reads'],
                ['value' => 'read_time_long', 'label' => 'Long Reads'],
            ]
        ]);
    }

    public function show(Article $article): Response
    {
        // TODO: improve loading here, improve comment relationship inclusion, ...
        // //'images:id,article_id,name,description,image', // article_image relation
        $article->load(['user', 'comments.author', 'comments.text', 'comments.created_at', 'images']);

        return Inertia::render('Article/Show', [
            'article' => array_merge($article->toArray(), [
                'read_time' => calculateReadTime($article->content),
                'similar_articles' => getSimilarArticles($article),
            ]),
        ]);
    }

}
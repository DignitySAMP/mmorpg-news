<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;



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
            ->with(['user:id,name,email'])  // user relation
            ->withCount('comments'); // only add full comment count

        // apply search text and sorting parameters
        if ($request->filled('search')) {
            $query->search($search);
        }
        
        if($request->filled('sortBy')) {
            switch($sortBy) {
                case 'newest': {
                    $query->sortByNewest();
                    break;
                }
                case 'oldest': {
                    $query->sortByOldest();
                    break;
                }
                case 'title_asc': {
                    $query->sortByTitleAsc();
                    break;
                }
                case 'title_desc': {
                    $query->sortByTitleDesc();
                    break;
                }
                case 'author': {
                    $query->sortByAuthor();
                    break;
                }
                case 'most_commented': {
                    $query->sortByComments();
                    break;
                }
                case 'read_time_short': {
                    $query->sortByReadTimeShort();
                    break;
                }
                case 'read_time_long': {
                    $query->sortByReadTimeLong();
                    break;
                }
            }
        }

        $articles = $query->paginate($perPage); // paginate current collection after search queries

        // calculate read_time on collection
        // TODO: Make this a db field instead that's auto calculated on store.
        $articles->getCollection()->transform(function ($article) {
            $article->read_time = $article->calculateReadTime();
            return $article;
        });
        
        return Inertia::render('Welcome', [
            'articles' => $articles,
            'filters' => [
                'sort_by' => $sortBy,
                'per_page' => $perPage,
                'search' => $search,
            ],
            'sort_options' => config('blog.sort_options')
        ]);
    }
}

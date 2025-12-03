<?php

use App\Models\Article;

    /*
    ** Applies sorting filters to query
    */

    function applySorting($query, string $sortBy)
    {
        return match($sortBy) {
            'newest' => $query->latest('created_at'),
            'oldest' => $query->oldest('created_at'),
            'title_asc' => $query->orderBy('title', 'asc'),
            'title_desc' => $query->orderBy('title', 'desc'),
            'author' => $query->join('users', 'articles.user_id', '=', 'users.id')
                              ->orderBy('users.name', 'asc')
                              ->select('articles.*'),
            'most_commented' => $query->withCount('comments')
                                      ->orderBy('comments_count', 'desc'),
            'read_time_short' => $query->orderByRaw('LENGTH(content) ASC'),
            'read_time_long' => $query->orderByRaw('LENGTH(content) DESC'),
            default => $query->latest('created_at'),
        };
    }

    /*
    ** Apply search filters to query
    */
    function applySearch($query, string $search)
    {
        $search = trim($search);
        
        if (empty($search)) {
            return $query;
        }

        // TODO: consider adding a FULLTEXT index when data grows beyond current scope
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
            ->orWhere('content', 'LIKE', "%{$search}%")
            ->orWhereHas('user', function ($userQuery) use ($search) {
                $userQuery->where('name', 'LIKE', "%{$search}%");
            });
        });

    }

    /*
    ** Build collection of similar articles 
    */
    function getSimilarArticles(Article $article, int $limit = 5)
    {
        return Article::query()
            ->with('user:id,name')
            ->where('id', '!=', $article->id)
            ->where(function ($query) use ($article) {
                $query->where('user_id', $article->user_id)
                      ->orWhereRaw('MATCH(title, content) AGAINST(? IN NATURAL LANGUAGE MODE)', 
                                   [substr($article->title, 0, 100)]);
            })
            ->limit($limit)
            ->get(['id', 'user_id', 'title', 'banner', 'created_at']);
    }

    /*
    ** Used to calculate read_time on demand in the stack
    */
    function calculateReadTime(string $content): int
    {
        // TODO: model still has an attribute for this, see if we can centralize this either here or in the model
        $wordCount = str_word_count(strip_tags($content));
        return max(1, ceil($wordCount / 170));
    }
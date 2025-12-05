<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'banner'];

    /*
    ** Eloquent Relationships
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }

    /*
    ** Scopes
    */

    public function scopeSortByTitleAsc($query) {
        return  $query->orderBy('title', 'asc');
    }
    public function scopeSortByTitleDesc($query) {
        return  $query->orderBy('title', 'desc');
    }

    public function scopeSortByNewest($query) {
        return  $query->latest('created_at');
    }

    public function scopeSortByOldest($query) {
        return  $query->oldest('created_at');
    }

    public function scopeSortByAuthor($query) {
        return $query->join('users', 'articles.user_id', '=', 'users.id')->orderBy('users.name', 'asc')->select('articles.*');
    }

    public function scopeSortByComments($query) {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopeSortByReadTimeShort($query) {
        return $query->orderByRaw('LENGTH(content) ASC');
    }

    public function scopeSortByReadTimeLong($query) {
        return $query->orderByRaw('LENGTH(content) DESC');
    }

    // Apply search filters to query
    public function scopeSearch($query, $search)
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
    ** Attributes
    */

    public function getSimilarArticles(Article $article, int $limit = 5)
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

    public function calculateReadTime(string $content): int
    {
        // TODO: make this a field instead?
        $wordCount = str_word_count(strip_tags($content));

        return max(1, ceil($wordCount / 170));
    }

}

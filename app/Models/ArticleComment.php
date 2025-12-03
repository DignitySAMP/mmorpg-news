<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleComment extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleCommentFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'article_id', 'text'];

    public function author(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function article(): BelongsTo 
    {
        return $this->belongsTo(Article::class);
    }
}

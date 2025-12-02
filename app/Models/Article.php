<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'banner'];

    /*
    ** Accessors / attributes
    */

    public function getSimilarArticlesAttribute(): Collection
    {
        return self::with(['user'])
            ->where('id', '!=', $this->id)
            ->where(function ($query): void {
                $query->where('title', $this->title)
                      ->orWhere('description', $this->description)
                      ->orWhereHas('user', function ($q): void {
                          $q->where('name', $this->user?->name);
                      });
            })
            ->inRandomOrder()
            ->limit(5)
            ->get();
    }

    public function getReadTimeAttribute(): int
    {
        $wordCount = str_word_count(strip_tags($this->content));
        return ceil($wordCount / 170); // 170 = +/- words per minute
    }

    /*
    ** Eloquent Relationships
    */

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany {
        return $this->hasMany(ArticleImage::class);
    }
    public function comments(): HasMany {
        return $this->hasMany(ArticleComment::class);
    }
}

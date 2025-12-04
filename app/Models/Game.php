<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'thumbnail',
        'short_description',
        'description',
        'genre',
        'platform',
        'publisher',
        'developer',
        'release_date',
        'minimum_system_requirements',
        'screenshots',
    ];

    protected $casts = [
        'minimum_system_requirements' => 'array',
        'screenshots' => 'array',
    ];
}

<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ArticleController::class, 'index'])->name('article.index');

Route::get('/article/create', function() {
    return Inertia::render('articles/Create');
})->name('article.create');

// TODO: make show article part of the slug, which should be editable in article editor
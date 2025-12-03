<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ArticleController::class, 'index'])->name('article.index');

// TODO: make show article part of the slug, which should be editable in article editor

Route::get('/article/{article}', function () {
    dd(auth()->user()->hasVerifiedEmail());
    return Inertia::render('Articles/Show');
})->middleware(['auth', 'verified'])->name('article.show');

Route::get('/user/profile', fn () => Inertia::render('Fortify/UpdateProfileInformation'))->middleware('auth');
Route::get('/user/profile/password', fn () => Inertia::render('Fortify/UpdatePasswordForm'))->middleware('auth');

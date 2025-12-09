<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [ArticleController::class, 'index'])->name('article.index');

// TODO: make show article part of the slug, which should be editable in article editor

Route::get('/article/{article}', function () {

    return Inertia::render('Articles/Show');
})->middleware(['auth', 'password.confirm', 'verified'])->name('article.show');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::get('/user/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::patch('/user/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::get('/user/profile/account', fn () => Inertia::render('Fortify/UpdateProfileInformation'))->middleware('auth')->name('profile.account');
Route::get('/user/profile/password', fn () => Inertia::render('Fortify/UpdatePasswordForm'))->middleware('auth')->name('profile.password');


Route::resource('game', GameController::class);

Route::get('test', fn() => Inertia::render('Test'))->name('test');
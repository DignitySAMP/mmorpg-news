<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /*
    ** This controller handles the viewing of public profiles.
    */

    // TODO: Add a centralized 'profile/edit' page where you can change account info (username, email), passwords, and profile info, which includes birthday, gender, location, ...
    // TODO: Add setting on profile where users can choose to hide their articles or comments or show as 'invisible'
    public function index(Request $request) {
        // If logged in, change avatar?
        // Default to 'my' profile which has an 'edit' button that links to 'user/profile' and 'user/profile/password'
    }

    // TODO: Make comments and articles searchable by string and date.
    public function show(Request $request, User $user) {
        return Inertia::render('Profile/Show', [
            'user' => $user,
            'articles'  => $user->articles()->latest()->paginate(10)->withQueryString(),
            'comments'  => $user->comments()->latest()->paginate(10)->withQueryString(),
        ]);
    }  
}

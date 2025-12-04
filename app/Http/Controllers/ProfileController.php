<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /*
    ** This controller handles the viewing of public profiles.
    */

    public function index(Request $request)
    {
        // If logged in, change avatar?
        
        $user = Auth::user();

        return Inertia::render('Profile/Index', [
            'user' => $user->load('profile'),
            'comments' => $user->comments()->latest()->paginate(10)->withQueryString(),
        ]);
    }

    // TODO: Make comments searchable by string and date.
    public function show(Request $request, User $user)
    {
        return Inertia::render('Profile/Show', [
            'user' => $user->load('profile'),
            'comments' => $user->comments()->latest()->paginate(10)->withQueryString(),
        ]);
    }

    public function update(Request $request) {
        $user = Auth::user();
        return Inertia::render('Profile/Edit', [
            'user' => $user->load('profile'),
        ]);
    }

    public function edit(Request $request) {
        $data = $request->validate([
            'country' => 'string|nullable',
            'gender' => [Rule::in(['male', 'female', 'other', 'hidden'])],
            'dob' => 'nullable|date',
            'privacy.show_profile' => 'boolean',
            'privacy.online_status' => 'boolean',
            'privacy.show_comments' => 'boolean',
        ]);
    
        $user = Auth::user();
        $user->load('profile');

        $user->profile->update([
            'location' => $data['country'],
            'gender' => $data['gender'],
            'date_of_birth' => $data['dob'],
            'show_profile' => $data['privacy']['show_profile'],
            'show_online_status' => $data['privacy']['online_status'],
            'show_comments' => $data['privacy']['show_comments'],
        ]);

        return redirect()->back();
    }
}

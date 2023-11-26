<?php

namespace App\Http\Controllers;

use App\models\User;
use App\models\Product;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $products = Product::all(); // Fetch all products from the database

        return view('user.index', ['products' => $products]);
    }

    public function tampildata()
    {
        $users = User::all();
        return view('dashboard', ['users' => $users]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Update user details
        $user->fill($request->validated());

        // Reset 'email_verified_at' if the email is changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Process avatar update
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $avatar = $request->file('avatar');
            $path = $avatar->store('avatars', 'public');

            $user->avatar = $path; // Simpan path avatar ke dalam basis data
        }

        $user->save();

        return redirect()->route('lohe')->with('alertMessage', 'Profil Anda telah diperbarui');
    }


    public function updateAvatar(Request $request): RedirectResponse
{
    $user = $request->user();

    // Process avatar update
    if ($request->hasFile('avatar')) {
        $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $avatar = $request->file('avatar');
        $path = $avatar->store('avatars', 'public');

        $user->avatar = $path; // Simpan path avatar ke dalam basis data
        $user->save();

        return redirect()->route('lohe')->with('alertMessage', 'Avatar Anda telah diperbarui');
    }

    return redirect()->route('lohe')->with('alertMessage', 'Tidak ada gambar yang dipilih.');
}

}

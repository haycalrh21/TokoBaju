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
        $user = Auth::user();
        $users = User::all();
        return view('dashboard', ['users' => $users]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Update user details
        $user->fill($request->except('avatar'));



        // Process avatar update
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $avatar = $request->file('avatar');
            $path = $avatar->store('avatars', 'public');

            $user->avatar = $path; // Simpan path avatar ke dalam basis data
        }

        // Validate and save changes to name and email
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->name = $request->input('name'); // Menetapkan perubahan nama

        info('Update User Data:', ['name' => $user->name, 'email' => $user->email]); // Log data

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

            $user->avatar = $path; // Save avatar path to the database
        }

        // Validate and save changes to name
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Set the new name
        $newName = $request->input('name');

        // Check if the new name is different
        if ($user->name !== $newName) {
            // Validate uniqueness of the new name
            $request->validate([
                'name' => 'unique:users,name',
            ]);

            // Save changes to the name
            $user->name = $newName; // Set the new name
        }

        // Validate and save changes to email
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Set the new email
        $newEmail = $request->input('email');

        // Check if the new email is different
        if ($user->email !== $newEmail) {
            // Validate uniqueness of the new email
            $request->validate([
                'email' => 'unique:users,email',
            ]);

            // Save changes to the email
            $user->email = $newEmail; // Set the new email
        }

        info('Update User Data:', ['name' => $user->name, 'email' => $user->email]); // Log data

        $user->save();

        return redirect()->route('lohe')->with('alertMessage', 'Profil Anda telah diperbarui');
    }



}

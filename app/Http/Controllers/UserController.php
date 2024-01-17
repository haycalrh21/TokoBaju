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

        // Proses pembaruan avatar
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $avatar = $request->file('avatar');
            $path = $avatar->store('avatars', 'public');

            $user->avatar = $path; // Simpan path avatar ke database
        }

        // Validate dan simpan perubahan nama
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Set nama baru
        $newName = $request->input('name');

        // Periksa apakah nama baru berbeda
        if ($user->name !== $newName) {
            // Validasi keunikan nama baru
            $request->validate([
                'name' => 'unique:users,name',
            ]);

            // Simpan perubahan nama
            $user->name = $newName; // Set nama baru
        }

        $request->validate([
            'alamat' => 'nullable|string|max:255',
        ]);

        // Set alamat baru
        $newAddress = $request->input('alamat');

        // Periksa apakah alamat baru berbeda
        if ($user->alamat !== $newAddress) {
            $user->alamat = $newAddress; // Set alamat baru
        }

        // Validate dan simpan perubahan nomor telepon
        $request->validate([
            'nohp' => 'nullable|string|max:13',
        ]);

        // Set nomor telepon baru
        $newPhoneNumber = $request->input('nohp');

        // Periksa apakah nomor telepon baru berbeda
        if ($user->nohp !== $newPhoneNumber) {
            $user->nohp = $newPhoneNumber; // Set nomor telepon baru
        }

        // Validate dan simpan perubahan email
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Set email baru
        $newEmail = $request->input('email');

        // Periksa apakah email baru berbeda
        if ($user->email !== $newEmail) {
            // Validasi keunikan email baru
            $request->validate([
                'email' => 'unique:users,email',
            ]);

            // Simpan perubahan email
            $user->email = $newEmail; // Set email baru
        }

        info('Update Data Pengguna:', [
            'nama'         => $user->name,
            'email'        => $user->email,
            'nohp'         => $user->nohp,
            'alamat'       => $user->alamat,
        ]); // Catat data

        $user->save();

        return redirect()->route('lohe')->with('alertMessage', 'Profil Anda telah diperbarui');
    }


}

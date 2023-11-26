<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function index()
    {
        $products = Product::all(); // Fetch all products from the database

        return view('user.index', ['products' => $products]);
    }
}

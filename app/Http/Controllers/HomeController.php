<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('page.user.welcome')->with('products', $products);
    }

    public function tampilbaju(){
        $products = Product::all();
        return view('page.user.product.index',compact('products'));
    }

    public function detailbaju($id){
        $product= Product::with('sizes')->find($id);

        return view('page.user.product.detail.index',compact('product'));
    }


}

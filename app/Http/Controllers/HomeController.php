<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('welcome')->with('products', $products);
    }

    public function tampilbaju(){
        $products = Product::all();
        return view('product/product',compact('products'));
    }

    public function detailbaju($id){
        $product= Product::with('sizes')->find($id);

        return view('product.detail',compact('product'));
    }

    public function coba(){
        return view('product.coba');
    }
}

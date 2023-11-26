<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addItem(Request $request)
    {
        // Validasi permintaan atau otentikasi pengguna jika diperlukan

        // Ambil data yang dikirim dari klien
        $productName = $request->input('name');
        $productPrice = $request->input('price');

        // Lakukan logika untuk menambahkan item ke keranjang
        // Misalnya, Anda bisa menyimpan item ke dalam basis data atau session

        // Contoh menggunakan session (perhatikan bahwa ini hanya contoh sederhana)
        $cart = $request->session()->get('cart', []);
        $cart[] = ['name' => $productName, 'price' => $productPrice];
        $request->session()->put('cart', $cart);

        // Respon jika item berhasil ditambahkan ke keranjang
        return response()->json(['message' => 'Item added to cart'], 200);
    }
}

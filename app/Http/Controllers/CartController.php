<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;

use App\Models\CartItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CartController extends Controller
{
    // Menampilkan isi keranjang
    public function index(Request $request)
    {
        // Mengambil user yang sedang login
        $user = Auth::user();

        // Mendapatkan keranjang pengguna (jika ada)
        $cart = $user->cart;

        // Mendapatkan semua item dalam keranjang
        $cartItems = $cart ? $cart->cartItems : collect(); // Use a ternary operator to handle a null cart

        $response = Http::withHeaders([
            'key' => '2efe421c944cd428ec4602fb44042c45'
        ])->get('https://api.rajaongkir.com/starter/city');

        $responseCost = Http::withHeaders([
            'key' => '2efe421c944cd428ec4602fb44042c45'
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $request->origin,
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier
        ]);

        $cities = $response['rajaongkir']['results'] ;
        $ongkir = $responseCost['rajaongkir'] ;

        return view('carts.index', compact('cartItems','cities','ongkir'));
    }


public function cekongkir(Request $request){

 // Mengambil user yang sedang login
 $user = Auth::user();

 // Mendapatkan keranjang pengguna (jika ada)
 $cart = $user->cart;

 // Mendapatkan semua item dalam keranjang
 $cartItems = $cart ? $cart->cartItems : collect(); // Use a ternary operator to handle a null cart

    $response = Http::withHeaders([
        'key' => '2efe421c944cd428ec4602fb44042c45'
    ])->get('https://api.rajaongkir.com/starter/city');

    $responseCost = Http::withHeaders([
        'key' => '2efe421c944cd428ec4602fb44042c45'
    ])->post('https://api.rajaongkir.com/starter/cost', [
        'origin' => $request->origin,
        'destination' => $request->destination,
        'weight' => $request->weight,
        'courier' => $request->courier
    ]);

    $cities = $response['rajaongkir']['results'] ;
    $ongkir = $responseCost['rajaongkir'] ;



    return view('carts.index',compact('cartItems','cities','ongkir'));
}



public function addToCart(Request $request, $productId)
{
    // Validasi request
    $request->validate([
        'quantity.' . $productId => 'required|integer|min:1',
        'ukuran.' . $productId => 'required|exists:product_sizes,size',
    ]);

    // Mengambil user yang sedang login
    $user = Auth::user();

    // Mencari atau membuat keranjang untuk user
    $cart = Cart::firstOrCreate(['user_id' => $user->id]);

    // Mencari item keranjang yang sesuai dengan produk dan ukuran
    $cartItem = $cart->cartItems()
        ->where('product_id', $productId)
        ->where('size', $request->input('ukuran.' . $productId))
        ->first();

    // Mengambil harga dari produk
    $harga = Product::findOrFail($productId)->harga;

    // Jika item sudah ada, tambahkan jumlah item dalam keranjang
    if ($cartItem) {
        $cartItem->quantity += $request->input('quantity.' . $productId);
        $cartItem->save();
    } else {
        // Jika item belum ada, buat item baru dalam keranjang
        $cartItem = new CartItems([
            'product_id' => $productId,
            'size' => $request->input('ukuran.' . $productId),
            'quantity' => $request->input('quantity.' . $productId),
            'harga' => $harga,
        ]);
        $cart->cartItems()->save($cartItem);
    }

    return redirect()->route('carts.index')->with('success', 'Produk berhasil ditambahkan ke dalam keranjang.');
}



    // Menghapus produk dari keranjang
    public function removeFromCart($cartItemId)
    {
        // Menghapus item keranjang berdasarkan ID
        CartItems::destroy($cartItemId);

        // Check if the user's cart is empty after removing the item
        $user = Auth::user();
        if ($user->cart->cartItems->isEmpty()) {
            // If the cart is empty, delete the cart
            $user->cart->delete();
        }

        return redirect()->route('carts.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

}

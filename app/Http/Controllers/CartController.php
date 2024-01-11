<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;

use App\Models\CartItems;
use App\Models\Pengiriman;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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



        return view('carts.index', compact('cartItems'));
    }


    public function simpan(Request $request)
    {
        try {
            // Validasi data yang diterima dari formulir
            $request->validate([
                'harga' => 'required|numeric',
                'kota_asal' => 'required|string',
                'kota_tujuan' => 'required|string',
                'service' => 'required|string',
                'estimasi_hari' => 'required|string',
            ]);
    
            $userId = auth()->id();
    
            // Ambil cart_id terakhir yang dimiliki oleh user dengan user_id terakhir
            $cartId = Checkout::where('user_id', $userId)->latest('id')->value('cart_id');
    
            $pengiriman = new Pengiriman([
                'cart_id' => $cartId,
                'user_id' => $userId,
                'harga' => $request->input('harga'),
                'kota_asal' => $request->input('kota_asal'),
                'kota_tujuan' => $request->input('kota_tujuan'),
                'service' => $request->input('service'),
                'estimasi_hari' => $request->input('estimasi_hari'),
            ]);
    
            $pengiriman->save();
    
            // Tambahkan logika penjumlahan harga di sini
            $checkOuts = Checkout::where('user_id', $userId)->where('cart_id', $cartId)->get();
            
            foreach ($checkOuts as $checkOut) {
                $checkOut->totalPrice += $pengiriman->harga;
    
                \Midtrans\Config::$serverKey = config('midtrans.serverKey');
                \Midtrans\Config::$isProduction = false;
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;
    
                $params = [
                    'transaction_details' => [
                        'order_id' => $cartId, // Menggunakan cart_id sebagai order_id
                        'gross_amount' => $checkOut->totalPrice, // Sesuaikan sesuai kebutuhan
                    ],
                ];
    
                // Mendapatkan Snap Token dari Midtrans
                $snapToken = \Midtrans\Snap::getSnapToken($params);
    
                // Simpan snap_token ke dalam kolom snap_token
                $checkOut->snap_token = $snapToken;
    
                $checkOut->save();
            }
            session()->put('_token', csrf_token());

            return redirect()->route('invoice');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    
    





public function cekongkir(Request $request){

 // Mengambil user yang sedang login


 // Mendapatkan keranjang pengguna (jika ada)


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

    // Tambahkan log atau pesan debugging
    // Log::info('Response Cost:', $responseCost);

    $cities = $response['rajaongkir']['results'];
    $ongkir = $responseCost['rajaongkir'];

    return view('ongkir.index', compact('cities', 'ongkir'));
}



public function coba(){
    return view('product.coba');

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


    return redirect()->route('carts.index',)->with('success', 'Produk berhasil ditambahkan ke dalam keranjang.');
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

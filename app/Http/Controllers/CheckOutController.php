<?php

// app/Http/Controllers/CheckOutController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\CheckOut;
use App\Models\CartItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CheckOutController extends Controller
{



    public function masukcekongkos(Request $request)
    {
        try {
            $cartItems = $request->input('cartItems');
            $totalPrice = $request->input('totalPrice');
            $userId = Auth::id();

            if (!is_null($cartItems)) {
                foreach ($cartItems as $cartItemData) {
                    // Get the latest cart for the user
                    $tahun = date('Y');
                    $bulan = date('m');
                    $tanggal = date('d');

                    // Generate random number between 1000 and 9999
                    $randomNumber = rand(1000, 9999);

                    // Combine date and random number
                    $cartId = $tahun . $bulan . $tanggal . $randomNumber;

                    // Create Checkout for the current item
                    CheckOut::create([
                        'cart_id' => $cartId,
                        'user_id' => $userId,
                        'product_id' => $cartItemData['product_id'],
                        'namabarang' => $cartItemData['namabarang'],
                        'jenisbarang' => $cartItemData['jenisbarang'],
                        'size' => $cartItemData['size'],
                        'quantity' => $cartItemData['quantity'],
                        'harga' => $cartItemData['harga'],
                        'totalPrice' => $totalPrice,
                    ]);

                    // Create Order for the current item
                    Order::create([
                        'cart_id' => $cartId,
                        'user_id' => $userId,
                        'product_id' => $cartItemData['product_id'],
                        'namabarang' => $cartItemData['namabarang'],
                        'jenisbarang' => $cartItemData['jenisbarang'],
                        'size' => $cartItemData['size'],
                        'quantity' => $cartItemData['quantity'],
                        'harga' => $cartItemData['harga'],
                        'totalPrice' => $totalPrice,
                    ]);
                }
            }

            // Redirect to the specified route with the latest cart ID
            return redirect()->route('cekongkoskirim');
        } catch (\Exception $e) {
            // Handle exceptions here
            dd("Error: " . $e->getMessage());
        }
    }







public function cekongkoskirim(Request $request)
{
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

    return view('page.user.ongkir.index', compact('cities','ongkir'));
}
public function cekongkoskirim1(Request $request)
{
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

    return view('page.user.ongkir.index', compact('cities','ongkir'));
}



public function gantistatus(Request $request)
{
    try {
        $orderId = $request->input('orderId');

        // Log untuk memeriksa nilai orderId
        Log::info('Order ID: ' . $orderId);

        // Temukan entri checkout dengan cart_id yang sama
        $checkouts = CheckOut::where('cart_id', $orderId)->get();

        // Log untuk memeriksa hasil pencarian checkouts
        Log::info('Checkouts: ' . $checkouts);

        if ($checkouts->isEmpty()) {
            throw new \Exception('No checkout found for order ID: ' . $orderId);
        }

        // Ubah status pada tabel CheckOut
        $checkouts->each(function ($checkout) {
            $checkout->update(['status' => 'sudah bayar']);
        });

        // Ubah status pada tabel Order
        Order::where('cart_id', $orderId)->update(['status' => 'sudah bayar']);
        CheckOut::where('cart_id', $orderId)->update(['status' => 'sudah bayar']);

        // Hapus keranjang belanja pengguna setelah pembayaran selesai
        $user = auth()->user();
        $user->cart->delete();

        return response()->json(['message' => 'Payment status updated successfully'], 200);
    } catch (\Exception $e) {
        // Log kesalahan
        Log::error('Error updating payment status: ' . $e->getMessage());

        return response()->json(['message' => 'Error updating payment status'], 500);
    }
}





public function hapusco(Request $request)
{
    try {
        // Pastikan pengguna yang menghapus data adalah pengguna yang sesuai
        $userId = Auth::id();

        // Ambil checkout terbaru untuk pengguna yang terautentikasi
        $latestCheckout = Checkout::where('user_id', $userId)
            ->latest('id')
            ->first();
        $latestOrder = Order::where('user_id', $userId)
            ->latest('id')
            ->first();

        if (!$latestCheckout) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Hapus checkout terbaru
        $latestCheckout->delete();
        $latestOrder->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
    }
}








}

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
                    // Periksa apakah kunci 'namabarang' ada dalam $cartItemData
                    if (array_key_exists('namabarang', $cartItemData)) {
                        $cartId = Cart::first()->id;
                        $existingCheckout = CheckOut::where('cart_id', $cartId)->first();

                        CheckOut::create([
                            'id' => $cartId,
                            'cart_id' => $cartId,
                            'user_id' => $userId,
                            'product_id' => $cartItemData['product_id'],
                            'namabarang' => $cartItemData['namabarang'],
                            'jenisbarang' => $cartItemData['jenisbarang'],
                            'size' => $cartItemData['size'],
                            'quantity' => $cartItemData['quantity'],
                            'harga' => $cartItemData['harga'],
                            'totalPrice' => $totalPrice,
                            // ... tambahkan atribut lainnya
                        ]);

                        Order::create([
                            'id' => $cartId,
                            'cart_id' => $cartId,
                            'user_id'=> $userId,
                            'product_id' => $cartItemData['product_id'],
                            'namabarang' => $cartItemData['namabarang'],
                            'jenisbarang' => $cartItemData['jenisbarang'],
                            'size' => $cartItemData['size'],
                            'quantity' => $cartItemData['quantity'],
                            'harga' => $cartItemData['harga'],
                            'totalPrice' => $totalPrice,
                        ]);
                    } else {
                        // Kunci 'namabarang' tidak ditemukan dalam $cartItemData
                        // Tangani kasus ini sesuai kebutuhan Anda
                    }
                }
            }

            return redirect()->route('cekongkoskirim', ['id' => $cartId]);

        } catch (\Exception $e) {
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

        // Find the checkout entries with the same cart_id
        $checkouts = Checkout::where('cart_id', $orderId)->get();

        if ($checkouts->isEmpty()) {
            throw new \Exception('No checkout found for order ID: ' . $orderId);
        }

        $user = Auth::user();
        $hasPaidEntry = false;

        foreach ($checkouts as $checkout) {
            // Check if any entry has already been paid
            if ($checkout->status === 'sudah bayar') {
                $hasPaidEntry = true;
                break;
            }
        }

        // Update the status for all entries if any of them has not been paid
        if (!$hasPaidEntry) {
            foreach ($checkouts as $checkout) {
                $checkout->status = 'sudah bayar';
                $checkout->save();
            }

            $user->cart->delete();

        } else {
            // Log that the status is already 'sudah bayar'
            Log::info('Payment status is already "sudah bayar" for order ID: ' . $orderId);
        }

        return response()->json(['message' => 'Payment status updated successfully'], 200);
    } catch (\Exception $e) {
        // Log the error
        Log::error('Error updating payment status: ' . $e->getMessage());

        return response()->json(['message' => 'Error updating payment status'], 500);
    }
}

public function hapusco($coId)
{
    try {
        // Pastikan pengguna yang menghapus data adalah pengguna yang sesuai
        $userId = Auth::id();
        $checkout = CheckOut::where('id', $coId)->where('user_id', $userId)->firstOrFail();

        // Hapus entri checkout
        $checkout->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 500);
    }
}





}

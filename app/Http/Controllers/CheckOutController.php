<?php

// app/Http/Controllers/CheckOutController.php

namespace App\Http\Controllers;

use App\Models\Cart;
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

            // Get the user ID (assuming the user is authenticated)
            $userId = Auth::id();

            // Pastikan $cartItems memiliki nilai sebelum melakukan iterasi
            if (!is_null($cartItems)) {
                // Process the cart items as needed
                foreach ($cartItems as $cartItemData) {
                    // Logika untuk mendapatkan ID tambahan, contoh: timestamp
                    $additionalId = time();

                    // Save data to the database using the CheckOut model
                    CheckOut::create([
                        'id' => $additionalId,
                        'cart_id' => $additionalId,
                        'user_id' => $userId,
                        'product_id' => $cartItemData['product_id'],
                        'size' => $cartItemData['size'],
                        'quantity' => $cartItemData['quantity'],
                        'harga' => $cartItemData['harga'],
                        'totalPrice' => $totalPrice,
                        // ... tambahkan atribut lainnya
                    ]);
                }
            }

            // Letakkan dd di sini setelah proses yang di atas sudah berjalan

            // return redirect()->route('cekongkoskirim',compact('cartItems','cities','ongkir'));
            return redirect()->route('cekongkoskirim');
        } catch (\Exception $e) {
            // Tangani exception di sini
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

    return view('ongkir.index', compact('cities','ongkir'));
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

    return view('ongkir.index', compact('cities','ongkir'));
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





}

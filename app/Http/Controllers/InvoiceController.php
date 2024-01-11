<?php

namespace App\Http\Controllers;

use App\Models\CheckOut;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Midtrans\Notification;
class InvoiceController extends Controller
{
    public function invoice()
    {
        // Assuming you want the latest checkout, you can adjust the query as needed
        $latestCheckout = CheckOut::latest()->first();
    
        if ($latestCheckout) {
            $checkoutItems = CheckOut::where('user_id', $latestCheckout->user_id)
                ->where('totalPrice', $latestCheckout->totalPrice)
                ->get();
    
            $totalAmount = $latestCheckout->totalPrice;
    
            // Ambil Snap Token dari objek $latestCheckout
            $snapToken = $latestCheckout->snap_token;
    
            // Check if there are recent cart items
            if ($checkoutItems->isNotEmpty()) {
                // Jika Snap Token ditemukan, kirimkan ke view
                if ($snapToken) {
                    return view('product.invoice', [
                        'checkoutItems' => $checkoutItems,
                        'totalAmount' => $totalAmount,
                        'snapToken' => $snapToken,
                    ]);
                } else {
                    // Jika Snap Token tidak ditemukan, tampilkan pesan
                    return view('product.invoice', ['checkoutItems' => $checkoutItems, 'totalAmount' => $totalAmount])->with('message', 'Snap Token tidak ditemukan.');
                }
            } else {
                // Jika item keranjang tidak ditemukan, tampilkan pesan
                return view('product.invoice', ['checkoutItems' => $checkoutItems, 'totalAmount' => $totalAmount])->with('message', 'Tidak ada item checkout terbaru.');
            }
        } else {
            // Handle the case where there are no checkouts
            return view('product.invoice', ['checkoutItems' => [], 'totalAmount' => 0])->with('message', 'Tidak ada checkout terbaru.');
        }
    }
    

    public function callback(Request $request)
{
    try {
        $payload = $request->getContent();
        $signatureKey = config('midtrans.serverKey'); // Use your server key here
        $notification = new Notification($payload);

        // Verify the signature
        if (!$notification->isValidSignature($signatureKey)) {
            throw new \Exception('Invalid signature');
        }

        // Handle the notification data
        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;

        // Process successful payment
        if ($transactionStatus == 'capture') {
            // Use your logic here
            // For example, update the 'check_outs' table status to 'sudah bayar'
            $checkout = Checkout::where('cart_id', $orderId)->first();

            if ($checkout && $checkout->status !== 'sudah bayar') {
                $checkout->status = 'sudah bayar';
                $checkout->save();
                
                // Log success
                \Log::info('Payment status updated to "sudah bayar" successfully for order ID: ' . $orderId);
            } else {
                // Log that the status is already 'sudah bayar' or checkout not found
                \Log::info('Payment status is already "sudah bayar" or checkout not found for order ID: ' . $orderId);
            }

            // Send response to Midtrans
            return response('OK', 200);
        } else {
            // Handle other transaction statuses if needed
            // For example, if the transaction status is pending or failed
        }
    } catch (\Exception $e) {
        // Log the error
        \Log::error('Midtrans Callback Error: ' . $e->getMessage());

        // Send response to Midtrans
        return response('Error', 500);
    }
}

    

}

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
        // Get the currently logged-in user
        $user = auth()->user();

        // Retrieve checkout items with product relationships for the logged-in user and filter by 'belum bayar'
        $checkoutItems = CheckOut::with('product')
            ->where('user_id', $user->id)
            ->where('status', 'belum bayar')
            ->get();

        // If there are items with 'belum bayar' status
        if ($checkoutItems->isNotEmpty()) {
            // Group items by cart_id
            $groupedCheckoutItems = $checkoutItems->groupBy('cart_id');

            return view('page.user.pembayaran.index', [
                'groupedCheckoutItems' => $groupedCheckoutItems,
            ]);
        } else {
            // If there are no items with 'belum bayar' status
            return view('page.user.pembayaran.index')->with('message', 'Tidak ada pembayaran yang belum dibayar.');
        }
    }





//     public function callback(Request $request)
// {
//     try {
//         $payload = $request->getContent();
//         $signatureKey = config('midtrans.serverKey'); // Use your server key here
//         $notification = new Notification($payload);

//         // Verify the signature
//         if (!$notification->isValidSignature($signatureKey)) {
//             throw new \Exception('Invalid signature');
//         }

//         // Handle the notification data
//         $orderId = $notification->order_id;
//         $transactionStatus = $notification->transaction_status;

//         // Process successful payment
//         if ($transactionStatus == 'capture') {
//             // Use your logic here
//             // For example, update the 'check_outs' table status to 'sudah bayar'
//             $checkout = Checkout::where('cart_id', $orderId)->first();

//             if ($checkout && $checkout->status !== 'sudah bayar') {
//                 $checkout->status = 'sudah bayar';
//                 $checkout->save();

//                 // Log success
//                 Log::info('Payment status updated to "sudah bayar" successfully for order ID: ' . $orderId);
//             } else {
//                 // Log that the status is already 'sudah bayar' or checkout not found
//                 Log::info('Payment status is already "sudah bayar" or checkout not found for order ID: ' . $orderId);
//             }

//             // Send response to Midtrans
//             return response('OK', 200);
//         } else {
//             // Handle other transaction statuses if needed
//             // For example, if the transaction status is pending or failed
//         }
//     } catch (\Exception $e) {
//         // Log the error
//         \Log::error('Midtrans Callback Error: ' . $e->getMessage());

//         // Send response to Midtrans
//         return response('Error', 500);
//     }
// }



}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CheckOut;

use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    public function invoice()
    {
        // Get the currently logged-in user
        $user = auth()->user();

        // Ambil riwayat pesanan (semua pesanan) untuk user saat ini
        $riwayat = Order::where('user_id', $user->id)->get();

        // Retrieve checkout items with product relationships for the logged-in user and filter by 'belum bayar'
        $checkoutItems = CheckOut::with('product')
            ->where('user_id', $user->id)
            ->where('status', 'belum bayar')
            ->get();

        // Jika ada riwayat pesanan
        if ($riwayat->isNotEmpty()) {
            // Tampilkan tampilan pembayaran dengan riwayat pesanan

            $groupedCheckoutItems = $checkoutItems->groupBy('cart_id');

            return view('page.user.pembayaran.index', [
                'riwayat' => $riwayat,
                'groupedCheckoutItems' => $groupedCheckoutItems,
            ]);
        }

        // Jika tidak ada riwayat pesanan, tetapi ada checkout items yang belum dibayar
        if ($checkoutItems->isNotEmpty()) {
            // Group items by cart_id
            $groupedCheckoutItems = $checkoutItems->groupBy('cart_id');

            return view('page.user.pembayaran.index', [
                'groupedCheckoutItems' => $groupedCheckoutItems,
                'riwayat' => $riwayat // Sertakan riwayat pesanan bahkan jika tidak ada riwayat
            ]);
        }

        // Jika tidak ada riwayat pesanan dan tidak ada checkout items yang belum dibayar
        return view('page.user.pembayaran.index')->with('message', 'Tidak ada pembayaran yang belum dibayar.');
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

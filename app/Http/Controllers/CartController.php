<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;

use App\Models\Order;
use App\Models\Product;
use App\Models\Checkout;
use App\Models\CartItems;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;


class CartController extends Controller
{
    // Menampilkan isi keranjang
    public function index(Request $request)
    {
        try {
            $user = Auth::user();
            $products = Product::all();
            $cart = $user->cart;
            $cartItems = $cart ? $cart->cartItems : collect();

            // Periksa apakah ada data checkout yang ada
            $existingCheckouts = CheckOut::where('user_id', $user->id)->where('status', 'belum bayar')->get();

            if ($existingCheckouts->isNotEmpty()) {
                // Jika ada setidaknya satu checkout dengan status "belum bayar"
                // Redirect ke cekongkoskirim dengan parameter id checkout pertama yang ditemukan
                return Redirect::route('cekongkoskirim', ['id' => $existingCheckouts->first()->id]);
            }

            return view('page.user.carts.index', compact('cartItems', 'products', 'existingCheckouts'));

        } catch (\Exception $e) {
            // Tangani exception di sini
            dd("Error: " . $e->getMessage());
        }
    }



    public function simpan(Request $request)
    {
        try {
            // Validasi data yang diterima dari formulir
            $request->validate([
                'hargaongkir' => 'required|numeric',
                'kota_asal' => 'required|string',
                'kota_tujuan' => 'required|string',
                'service' => 'required|string',
                'estimasi_hari' => 'required|string',

            ]);

            $userId = auth()->id();

            // Ambil cart_id terakhir yang dimiliki oleh user dengan user_id terakhir
            $cartId = Checkout::where('user_id', $userId,)->latest('id')->value('cart_id');
            $alamat = User::where('id',$userId)->latest('id')->value('alamat');

            $pengiriman = new Pengiriman([
                'cart_id' => $cartId,
                'user_id' => $userId,
                'hargaongkir' => $request->input('hargaongkir'),
                'kota_asal' => $request->input('kota_asal'),
                'kota_tujuan' => $request->input('kota_tujuan'),
                'service' => $request->input('service'),
                'estimasi_hari' => $request->input('estimasi_hari'),
            ]);

            $orderan = Order::find($cartId);


            if($orderan){
                $orderan->update([

                    'cart_id' => $cartId,
                    'user_id' => $userId,
                    'alamat'=> $alamat,
                    'hargaongkir' => $request->input('hargaongkir'),
                    'kota_asal' => $request->input('kota_asal'),
                    'kota_tujuan' => $request->input('kota_tujuan'),
                    'service' => $request->input('service'),
                    'estimasi_hari' => $request->input('estimasi_hari'),
                ]);
            }


            $pengiriman->save();
            $orderan->update();

            // Tambahkan logika penjumlahan harga di sini
            $checkOuts = Checkout::where('user_id', $userId)->where('cart_id', $cartId)->get();

            $snapToken = null;
            foreach ($checkOuts as $checkOut) {
                $checkOut->totalPrice += $pengiriman->hargaongkir;

                $co = Product::find($checkOut->product_id);
                $checkOuts = Checkout::where('user_id', $userId)->where('cart_id', $cartId)->get();

                $cartId = $checkOut->cart_id;




                if (!$snapToken) {
                    \Midtrans\Config::$serverKey = config('midtrans.serverKey');
                    \Midtrans\Config::$isProduction = false;
                    \Midtrans\Config::$isSanitized = true;
                    \Midtrans\Config::$is3ds = true;

                    // $pengiriman = Pengiriman::where('cart_id', $cartId)->value('hargaongkir');


                    $admin = User::where('role', 'admin')->first();

                    $user = User::find($checkOut->user_id);


                    $pengiriman = Pengiriman::where('cart_id', $cartId)->first();

                    $checkoutItems = Checkout::where('cart_id', $cartId)
                    ->select('product_id', DB::raw('SUM(quantity) as totalQuantity'), DB::raw('SUM(harga) as totalHarga'))
                    ->groupBy('product_id')
                    ->get();
                    $totalHargaSemuaItem = 0;


                $params = [
                    'transaction_details' => [
                        'order_id' => $cartId,
                        'gross_amount' => $totalHargaSemuaItem,
                    ],

                    'item_details' => [],

                    'customer_details' => [
                        'first_name' => $user->name,
                        'phone' => $user->nohp,
                        'email' => $user->email,
                        'billing_address' => [
                            'first_name' => $user->name,
                            'email' => $user->email,
                            'phone' => $user->nohp,
                            'address' => $user->alamat,

                        ],'shipping_address' => [
                            'first_name' => $admin->name,
                            'email' => "test@midtrans.com",
                            'phone' => $admin->nohp,
                            // 'address' => $pengiriman->kota_asal,
                            'address' => $admin->alamat,
                            'city' => "jakarta",
                            'postal_code'=>"13840",

                        ],

                    ],

                ];

                foreach ($checkoutItems as $item) {

                    $pengiriman = Pengiriman::where('cart_id', $cartId)->first();

                    $product = Product::find($item->product_id);
                    $hargaOngkir = Pengiriman::where('user_id', $userId)
                    ->where('cart_id', $cartId)
                    ->value('hargaongkir');

                    $params['item_details'][] = [

                        'id' => $item->product_id,
                        'sub_total'=>($item->totalHarga *$item->totalQuantity)+$pengiriman->hargaongkir,
                        'price' => ($item->totalHarga) ,
                        'quantity' => $item->totalQuantity,
                        'name' => $product->namabarang,
                        'size' => $checkOut->size,
                        'brand' => $product->brand,
                    ];


                }
                // Menambahkan harga ongkir ke total harga dari keseluruhan item


                    // Get Snap Token only once for the same cart_id
                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                }


                // Save snap_token to the snap_token column
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





public function addToCart(Request $request, $productId)
{
    Try{
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


return redirect()->back()->with('success', 'Product added to cart successfully.');
    }catch(\Exception $e){

    }

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

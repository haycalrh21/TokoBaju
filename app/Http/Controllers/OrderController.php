<?php

namespace App\Http\Controllers;

use Log;
use App\Models\User;
use App\Models\Order;
use App\Models\Pembeli;
use App\Models\Product;
use App\Models\Keranjang;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class OrderController extends Controller
{

    public function order()
    {

        $response = Http::withHeaders([
            'key' => '2efe421c944cd428ec4602fb44042c45'
        ])->get('https://api.rajaongkir.com/starter/city');

        $cities = $response['rajaongkir']['results'];


        // dd($response->json());
        $products = Product::all();
        return view('product/order', ['products' => $products, 'cities' => $cities,  'ongkir' => '']);
    }

    public function tambahKeKeranjang(Request $request, $productId)
    {
        // Ambil produk dari database berdasarkan ID yang diberikan
        $product = Product::with('productSizes')->find($productId);

        // Periksa apakah 'selectedQuantity' ada dalam request
        if ($request->has('selectedQuantity')) {
            $selectedQuantity = $request->input('selectedQuantity');
            $selectedSizes = $request->input('ukuran');

            // Hitung total harga berdasarkan kuantitas yang dipilih dan harga produk
            $totalHarga = $product->harga * $selectedQuantity;

            // Siapkan data produk untuk disimpan dalam sesi
            $productData = [
                'id' => $product->id,
                'namabarang' => $product->namabarang,
                'brand' => $product->brand,
                'harga' => $product->harga,
                'selectedQuantity' => $selectedQuantity,
                'image' => $product->image,
                'total_harga' => $totalHarga,
                'jumlahbarang' => $request->input('jumlahbarang'), // Gunakan langsung dari input
                'ukuran' => $selectedSizes, // Menambahkan ukuran yang dipilih ke data produk
            ];

            // Dapatkan 'keranjang' saat ini dari sesi atau inisialisasi array kosong jika tidak ada
            $keranjang = session()->get('keranjang', []);

            // Periksa apakah produk dengan ID dan ukuran yang sama sudah ada di keranjang
            $existingProductKey = null;
            foreach ($keranjang as $key => $item) {
                if ($item['id'] == $productData['id'] && $item['ukuran'] == $productData['ukuran']) {
                    $existingProductKey = $key;
                    break;
                }
            }

            if ($existingProductKey !== null) {
                // Jika produk dengan ID dan ukuran yang sama sudah ada, update kuantitas
                $keranjang[$existingProductKey]['selectedQuantity'] += $selectedQuantity;
                // Perbarui total harga berdasarkan kuantitas yang baru
                $keranjang[$existingProductKey]['total_harga'] = $product->harga * $keranjang[$existingProductKey]['selectedQuantity'];
                // Perbarui total jumlah barang dengan menambahkan kuantitas yang baru
                $keranjang[$existingProductKey]['jumlahbarang'] += $selectedQuantity;
            } else {
                // Jika produk dengan ID dan ukuran yang sama belum ada, tambahkan ke keranjang
                $keranjang[] = $productData;
            }

            // Simpan 'keranjang' yang telah diperbarui kembali ke sesi
            session()->put('keranjang', $keranjang);

            // Redirect atau lakukan tindakan lebih lanjut
            $products = Product::all();
            return redirect()->route('order', ['products' => $products]);
        } else {
            // Tangani jika 'selectedQuantity' tidak ada dalam request
            // Redirect ke halaman error atau lakukan tindakan lain
        }
    }

    public function bayar(Request $request)
    {
        $user_id = auth()->id();
    
        $pembeli = Pembeli::create([
            'user_id' => $user_id,
            'namalengkap' => $request->input('namalengkap'),
            'email' => $request->input('email'),
            'alamat' => $request->input('alamat'),
            'origin' => $request->input('origin'),
            'destination' => $request->input('destination'),
            'kodepos' => $request->input('kodepos'),
            'courier' => $request->input('courier'),
            'notes' => $request->input('notes'),
        ]);
    
        $pembelian = Pembelian::create([
            'pembeli_id' => $pembeli->id,
        ]);
    
        $keranjangItems = session('keranjang');
    
        foreach ($keranjangItems as $item) {
            $jumlahBarang = $item['jumlahbarang'] ?? 0;
            $idBarang = $item['id'];
    
            $product = Product::find($idBarang);
    
            if ($product) {
                $selectedSizes = $item['ukuran'] ?? [];
                $ukuranAsString = implode(', ', $selectedSizes);
    
                $harga = $product->harga;
                $totalHarga = $jumlahBarang * $harga;
    
                Keranjang::create([
                    'product_id' => $idBarang,
                    'pembelian_id' => $pembelian->id,
                    'jumlahbarang' => $jumlahBarang,
                    'harga' => $harga,
                    'total_harga' => $totalHarga,
                    'namabarang' => $item['namabarang'],
                    'brand' => $item['brand'],
                    'ukuran' => $ukuranAsString,
                    'user_id' => $user_id,
                ]);
    
                if ($product->stok >= $jumlahBarang) {
                    $product->stok -= $jumlahBarang;
                    $product->save();
                } else {
                    // Action if stock is insufficient
                    // Misalnya: Membatalkan pembelian atau memberikan pesan kepada pengguna
                }
            }
        }
    
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $totalHarga, // Adjust as needed
            ],
        ];
    
        // Mendapatkan Snap Token dari Midtrans
        $snapToken = \Midtrans\Snap::getSnapToken($params);
    
        // Simpan Snap Token dalam sesi
        session()->put('snapToken', $snapToken);
    
        // Hapus keranjang setelah pembelian
        session()->forget('keranjang');
    
        // Redirect ke halaman 'selesai' dengan Snap Token dan pesan sukses
        return redirect()->route('selesai', ['snapToken' => $snapToken])->with('success', 'Pembelian sukses! Terima kasih.');
    }
    


    public function showInvoice()
{
    // Dapatkan pengguna yang sedang login
    $user = auth()->user();

    // Periksa apakah pengguna ada
    if ($user) {
        // Dapatkan item keranjang terbaru dari pengguna
        $latestCartItems = Keranjang::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Periksa apakah item keranjang ditemukan
        if ($latestCartItems->isNotEmpty()) {
            // Ambil Snap Token dari sesi
            $snapToken = session('snapToken');

            // Jika Snap Token ditemukan, kirimkan ke view
            if ($snapToken) {
                return view('product.invoice', ['keranjangItems' => $latestCartItems, 'snapToken' => $snapToken]);
            } else {
                // Jika Snap Token tidak ditemukan, tampilkan pesan
                return view('product.invoice')->with('message', 'Snap Token tidak ditemukan.');
            }
        } else {
            // Jika item keranjang tidak ditemukan, tampilkan pesan
            return view('product.invoice')->with('message', 'Tidak ada item keranjang terbaru.');
        }
    }

    // Jika pengguna tidak ditemukan, tampilkan pesan
    return view('product.invoice')->with('message', 'Pengguna tidak ditemukan.');
}






    public function updatePaymentStatus(Request $request)
    {
        $keranjangId = $request->input('keranjang_id');

        // Temukan keranjang berdasarkan ID
        $keranjang = Keranjang::find($keranjangId);

        // Update status pembayaran menjadi success
        $keranjang->update(['status_pembayaran' => 'success']);

        // Redirect atau kembali ke halaman sebelumnya
        return redirect()->back()->with('success', 'Payment status updated successfully');
    }




    public function indexorder()
    {
        $keranjangs = Keranjang::all();
        return view('admin/order/index', ['keranjangs' => $keranjangs]);
    }




    public function cancel(Request $request)
    {

        $request->session()->forget('keranjang');

        // Redirect atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan');
    }




    public function orderan(Request $request)
    {
        $user_id = $request->input('user_id'); // Mendapatkan $user_id dari request

        $user = Pembeli::find($user_id);

        if ($user) {
            $riwayatPembelian = $user->keranjangs;
            return view('orderan')->with('user', $user)->with('riwayatPembelian', $riwayatPembelian);
        } else {
            // Tangani jika pengguna tidak ditemukan
        }
    }
    public function cekOngkir(Request $request) {
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
    
        $products = Product::all();
    
        return view('product/order', ['products' => $products, 'cities' => $cities, 'ongkir' => $ongkir]);
    }

}



<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\CheckOut;
use App\Models\CartItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{


    public function dashboard()
    {

         $jumlahProduct = Product::count();
         $jumlahAkun = User::count();
         $jumlahCo = CheckOut::count();
         $jumlahKeranjang = CartItems::count();



        $usersWithPayments = User::whereHas('checkOuts', function ($query) {
            $query->where('status', 'sudah bayar');
        })->with('checkOuts')->get();

        $totalPriceData = [];
        $processedCombinations = [];

        foreach ($usersWithPayments as $user) {
            foreach ($user->checkOuts as $checkOut) {
                // Create a unique identifier based on cart_id and totalPrice
                $combinationKey = $checkOut->cart_id . '_' . $checkOut->totalPrice;

                // Check if the combination is not already processed
                if (!isset($processedCombinations[$combinationKey])) {
                    // Extract the month and year from the created_at timestamp
                    $monthYear = date('F Y', strtotime($checkOut->created_at));

                    // Accumulate the total for each month
                    if (!isset($totalPriceData[$monthYear])) {
                        $totalPriceData[$monthYear] = 0;
                    }

                    $totalPriceData[$monthYear] += $checkOut->totalPrice;

                    // Mark the combination as processed
                    $processedCombinations[$combinationKey] = true;
                }
            }
        }

        // Add monthly totals to the data array
        foreach ($totalPriceData as $monthYear => $total) {
            $totalPriceData['labels'][] = $monthYear;
            $totalPriceData['values'][] = $total;
        }

        return view('page.admin.dashboard', compact('usersWithPayments',
         'totalPriceData','jumlahProduct','jumlahAkun','jumlahCo',
        'jumlahKeranjang'));
    }


    public function productadmin()
    {
        $product = Product::all(); // Fetch all products from the database

        return view('page.admin.product.index', ['product' => $product]);
    }


    public function order()
    {
        $keranjangs = CheckOut::with('pengiriman','product')->get();


        return view('page.admin.order.index', compact('keranjangs',  ));
    }


    public function create()
    {


        return view('page.admin.product.create.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'namabarang' => 'required',
            'jenisbarang' => 'required',
            'brand' => 'required',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product', 'public');
        }

        $product = new Product([
            'namabarang' => $validatedData['namabarang'],
            'jenisbarang' => $validatedData['jenisbarang'],
            'brand' => $validatedData['brand'],
            'stok' => $validatedData['stok'],
            'harga' => $validatedData['harga'],
            'image' => $imagePath,
        ]);

        $product->save();

      // Simpan data ukuran ke dalam tabel product_sizes
foreach ($request->input('ukuran') as $size) {
    $product->productSizes()->create(['size' => $size]);
}


        return redirect()->route('productadmin')->with('sukses', 'Postingan akan di publish');
    }

    public function destroy($id){
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('productadmin');
    }

    public function show($id){
        $products = Product::find($id);

        return view('page.admin.product.show.index', compact('products'));

    }
}

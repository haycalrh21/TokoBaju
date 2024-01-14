<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\productSize;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function order()
    {
        return view('product/order');
    }
    public function checkout()
    {
        return view('product/checkout');
    }

    public function tambahKeKeranjang($product_id)
    {
        $product = Product::find($product_id);

        // Mengambil keranjang dari session atau membuat keranjang jika belum ada
        $keranjang = session()->get('keranjang', []);

        // Menambahkan produk ke keranjang
        $keranjang[] = $product;

        // Menyimpan kembali keranjang ke session
        session()->put('keranjang', $keranjang);

        return redirect()->route('indexproduct');
    }

    public function productadmin(){
        $usersWithPayments = User::whereHas('checkOuts', function ($query) {
            $query->where('status', 'sudah bayar');
        })->with('checkOuts')->get();
        $product = Product::all();

        // Tampilkan tampilan 'product.index' dengan data produk
        return view('admin/product/index', compact('product','usersWithPayments'));

    }


    public function create()
    {
        return view('admin/product/tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
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


        return redirect()->route('product.index')->with('sukses', 'Postingan akan di publish');
    }



    public function showProducts()
    {
        $products = Product::all(); // Fetch all products from the database

        return view('products.index', ['products' => $products]);
    }
    public function tampilindex()
    {
        $products = Product::all(); // Fetch all products from the database

        return view('welcome', ['products' => $products]);
    }

    public function show(string $id)
    {
      // Ambil data produk berdasarkan ID
      $product = Product::find($id);
      $products = Product::with('productSizes')->get();
      return view('product.show', compact('products'));
      // Tampilkan tampilan 'product.show' dengan data produk yang dipilih
      return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);

        // Tampilkan tampilan 'product.edit' dengan data produk yang akan diedit
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       // Validasi data yang diterima dari form
       $validatedData = $request->validate([
        'jenis_barang' => 'required',
        'brand' => 'required',
        'stok' => 'required|integer',
        'harga' => 'required|numeric',
        'image' => 'nullable|image',
    ]);

    // Ambil data produk berdasarkan ID
    $product = Product::find($id);

    // Update data produk dalam database
    $product->update($validatedData);

    // Unggah gambar jika ada
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
        $product->save();
    }

    // Redirect ke tampilan 'product.index' dengan pesan sukses
    return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus data produk berdasarkan ID
        $product = Product::find($id);
        $product->delete();

        // Redirect ke tampilan 'product.index' dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');

    }

}




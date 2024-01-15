<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Route::get('/',[HomeController::class, 'index'])->name('index');
Route::get('/product',[HomeController::class, 'tampilbaju'])->name('indexproduct');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth','role:admin')->group(function(){
    Route::get('/admin/dashboard',[AdminController::class, 'dashboard'])->name('admindashboard');
    Route::get('admin/product/index', [ProductController::class, 'productadmin'])->name('product.index');
    // Ganti rute "admin.product.index" dengan "admin.product.index"
    Route::get('admin/products/create', [ProductController::class, 'create'])->name('admin.product.create');
    Route::post('admin/products', [ProductController::class, 'store'])->name('admin.product.store');
    Route::get('admin/products/{product}', [ProductController::class, 'show'])->name('admin.product.show');
    Route::get('admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::put('admin/products/{product}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::delete('admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
    Route::get('admin/order/', [AdminController::class, 'order'])->name('tampilorder');
    Route::post('admin/order/check-payment-status/', [OrderController::class, 'updatePaymentStatus'])->name('updatePaymentStatus');

});


Route::middleware('auth','role:user')->group(function(){

    Route::get('/order',[ProductController::class, 'order'])->name('indexorder');

    Route::get('/dashboard',[UserController::class, 'tampildata'])->name('dashboard');
    Route::post('/dashboard', [UserController::class, 'updateAvatar'])->name('lohe');

    Route::get('/product/order', [OrderController::class, 'order'])->name('order');

    Route::post('/simpan',[CartController::class, 'simpan'])->name('simpandata');
    Route::post('/product/tambah-ke-keranjang/{product}', [OrderController::class, 'tambahKeKeranjang'])->name('tambah.ke.keranjang');

    Route::get('/coba', [CartController::class, 'coba'])->name('coba');


    Route::get('/user/riwayat/', [OrderController::class, 'orderan'])->name('orderan');

        Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
           Route::post('/carts/add/{productId}', [CartController::class, 'addToCart'])->name('carts.addToCart');

        Route::delete('/carts/remove/{cartItemId}', [CartController::class, 'removeFromCart'])->name('carts.removeFromCart');

        Route::post('/checkout', [CheckOutController::class, 'processCheckout'])->name('checkout');



        Route::post('/kirimdata', [CheckOutController::class, 'masukcekongkos'])->name('cekongkos');
        Route::get('/cekongkos', [CheckOutController::class, 'cekongkoskirim'])->name('cekongkoskirim');
        Route::post('/cekongkos', [CheckOutController::class, 'cekongkoskirim1'])->name('cekongkoskirim1');
        Route::post('/updatestatus', [CheckOutController::class, 'gantistatus'])->name('gantistatus');

        Route::get('/invoice', [InvoiceController::class, 'invoice'])->name('invoice');
        Route::post('/midtrans-callback', [InvoiceController::class, 'callback'])->name('callback');


Route::post('/user/product/cancel', [OrderController::class, 'cancel'])->name('cancel');


    Route::post('/user/product/order/complete', [OrderController::class, 'bayar'])->name('selesaiorder');
    Route::get('/user/product/order/complete', [OrderController::class, 'showInvoice'])->name('selesai');


});

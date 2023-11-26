<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::get('/',[ProductController::class, 'tampilindex'])->name('tampilindex');

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
    Route::get('admin/order/', [OrderController::class, 'indexorder'])->name('tampilorder');
    Route::post('admin/order/check-payment-status/', [OrderController::class, 'updatePaymentStatus'])->name('updatePaymentStatus');

});


Route::middleware('auth','role:user')->group(function(){
    Route::get('/user/index',[UserController::class, 'index'])->name('indexuser');
   Route::get('/user/product',[ProductController::class, 'index'])->name('indexproduct');
    Route::get('/user/order',[ProductController::class, 'order'])->name('indexorder');
    Route::get('/user/checkout',[ProductController::class, 'checkout'])->name('checkout');
    Route::get('/user/dashboard',[UserController::class, 'tampildata'])->name('dashboard');
    Route::post('/user/dashboard', [UserController::class, 'updateAvatar'])->name('lohe');

    Route::get('/user/product/order', [OrderController::class, 'order'])->name('order');
    Route::post('/user/product/tambah-ke-keranjang/{product}', [OrderController::class, 'tambahKeKeranjang'])->name('tambah.ke.keranjang');



    Route::get('/user/riwayat/', [OrderController::class, 'orderan'])->name('orderan');



// routes/web.php
Route::post('/user/product/cancel', [OrderController::class, 'cancel'])->name('cancel');


    Route::post('/user/product/order/complete', [OrderController::class, 'bayar'])->name('selesaiorder');
    Route::get('/user/product/order/complete', [OrderController::class, 'showInvoice'])->name('selesai');


});

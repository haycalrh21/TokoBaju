<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\AdminMessageController;



Route::get('/',[HomeController::class, 'index'])->name('index');
Route::get('/product',[HomeController::class, 'tampilbaju'])->name('indexproduct');
Route::get('/product/{id}',[HomeController::class, 'detailbaju'])->name('detailbaju');
Route::get('/coba',[HomeController::class, 'coba'])->name('coba');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth','role:admin')->group(function(){
    Route::get('admin/dashboard',[AdminController::class, 'dashboard'])->name('admindashboard');
    Route::get('admin/product/index', [AdminController::class, 'productadmin'])->name('productadmin');
    Route::get('admin/products/create', [AdminController::class, 'create'])->name('admin.product.create');
    Route::post('admin/products', [AdminController::class, 'store'])->name('admin.product.store');
    Route::get('admin/products/{id}', [AdminController::class, 'show'])->name('admin.product.show');
    Route::get('admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.product.edit');
    Route::put('admin/products/{product}', [ProductController::class, 'update'])->name('admin.product.update');
    Route::delete('admin/products/{product}', [AdminController::class, 'destroy'])->name('admin.product.destroy');
    Route::get('admin/order/', [AdminController::class, 'order'])->name('tampilorder');
    Route::post('admin/order/check-payment-status/', [OrderController::class, 'updatePaymentStatus'])->name('updatePaymentStatus');
    Route::get('/admin/messages', [AdminMessageController::class, 'showMessages'])->name('admin.message.index');
    Route::post('/admin/messages/reply/{id}', [AdminMessageController::class, 'replyMessage'])->name('admin.messages.reply');

});


Route::middleware('auth','role:user')->group(function(){



        Route::get('/dashboard',[UserController::class, 'tampildata'])->name('dashboard');
        Route::post('/dashboard', [UserController::class, 'updateAvatar'])->name('lohe');



        Route::post('/simpan',[CartController::class, 'simpan'])->name('simpandata');



        Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
        Route::post('/carts/add/{productId}', [CartController::class, 'addToCart'])->name('carts.addToCart');
        Route::delete('/carts/remove/{cartItemId}', [CartController::class, 'removeFromCart'])->name('carts.removeFromCart');
        Route::post('/checkout', [CheckOutController::class, 'processCheckout'])->name('checkout');



        Route::post('/kirimdata', [CheckOutController::class, 'masukcekongkos'])->name('cekongkos');
        Route::get('/cekongkos', [CheckOutController::class, 'cekongkoskirim'])->name('cekongkoskirim');
        Route::post('/cekongkos', [CheckOutController::class, 'cekongkoskirim1'])->name('cekongkoskirim1');
        Route::post('/updatestatus', [CheckOutController::class, 'gantistatus'])->name('gantistatus');

        Route::get('/invoice', [InvoiceController::class, 'invoice'])->name('invoice');



        Route::get('/messages', [MessageController::class, 'showMessages'])->name('messages.index');
        Route::post('/messages', [MessageController::class, 'storeMessage'])->name('messages.store');
        Route::post('/messages/{messageId}/reply', [MessageController::class, 'storeReply'])->name('messages.reply');


});

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('size')->nullable();
            $table->string('namabarang')->nullable();
            $table->string('jenisbarang')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kota_tujuan')->nullable();
            $table->string('hargaongkir')->nullable();
            $table->string('service')->nullable();
            $table->string('estimasi_hari')->nullable();

            $table->integer('quantity')->nullable();
            $table->decimal('harga', 10, 2)->nullable();
            $table->decimal('totalPrice', 10, 2)->nullable();
            $table->enum('status', ['belum bayar', 'sudah bayar'])->nullable()->default('belum bayar');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

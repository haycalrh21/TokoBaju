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
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->id();
            $table->string('namabarang');
            $table->string('brand');
            $table->string('ukuran')->nullable();
            $table->integer('jumlahbarang');
            $table->decimal('harga', 10, 2);
            $table->decimal('total_harga', 10, 2);
            $table->uuid('pembelian_id')->nullable();
            // $table->foreign('pembelian_id')->references('id')->on('pembelians');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->enum('status_pembayaran', ['pending', 'success', 'failed'])->default('pending');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjangs');
    }
};

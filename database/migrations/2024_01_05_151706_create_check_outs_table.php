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
        Schema::create('check_outs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->string('size');
            $table->string('snap_token')->nullable();
            $table->integer('quantity');
            $table->decimal('harga', 10, 2);
            $table->decimal('totalPrice', 10, 2);
            $table->enum('status', ['belum bayar', 'sudah bayar'])->nullable()->default('belum bayar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_outs');
    }
};

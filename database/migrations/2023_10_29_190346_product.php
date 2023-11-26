<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id'); // Gunakan 'id' sebagai primary key
            $table->string('namabarang');
            $table->string('jenisbarang');
            $table->string('brand');
            // $table->string('ukuran');
            $table->integer('stok');
            $table->decimal('harga', 10, 2);
            $table->string('image');
            $table->timestamps();
        });

    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};

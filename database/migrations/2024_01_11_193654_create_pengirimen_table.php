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
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('check_out_id');
            $table->unsignedBigInteger('user_id');
            $table->string('kota_asal');
            $table->string('kota_tujuan');
            $table->decimal('harga', 10, 2);
            $table->string('service');
            $table->integer('estimasi_hari');
            // tambahkan kolom lain sesuai kebutuhan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimans');
    }
};
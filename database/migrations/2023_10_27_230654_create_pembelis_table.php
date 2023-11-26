<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelisTable extends Migration {
    public function up(): void {
        Schema::create('pembelis', function (Blueprint $table) {
            $table->bigIncrements('id'); // Gunakan 'id' sebagai primary key
            $table->string('namalengkap');
            $table->string('email');
            $table->string('alamat');
            $table->string('provinsi');
            $table->string('kodepos');
            $table->string('pengiriman');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pembelis');
    }
}

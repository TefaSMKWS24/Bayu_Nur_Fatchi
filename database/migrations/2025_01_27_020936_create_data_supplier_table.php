<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->string('kode_supplier', 6)->primary();
            $table->string('nama_supplier', 20);  // Diubah dari 50 ke 20
            $table->string('nohp', 13);
            $table->string('kode_barang', 6);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supplier');
    }
};
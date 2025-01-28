<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('kode_transaksi', 6)->primary();
            $table->date('tanggal_transaksi');
            $table->string('kode_kasir', 6);
            $table->string('kode_pelanggan', 6);
            $table->string('kode_voucher', 6)->nullable();
            $table->string('diskon', 6)->nullable();
            $table->bigInteger('total_belanja');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
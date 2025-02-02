<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;
use App\Http\Controllers\AuthController;

// Route untuk guest (sebelum login)
Route::middleware(['guest'])->group(function () {
    // Route untuk Kasir
    Route::get('/kasir', function () {
        return view('auth.loginkasir');
    })->name('loginkasir');
    Route::post('/loginkasir', [AuthController::class, 'loginkasir']);

    
    Route::get('/admin', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/loginadmin', [AuthController::class, 'loginadmin']);
});

// Route untuk Kasir setelah login
Route::middleware(['auth:kasir'])->group(function () {
    Route::get('/kasir/dashboard', function() {
        return view('kasir.dashboard');
    });
    Route::get('/kasir/logout', [AuthController::class, 'logoutkasir']);
    
    
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('detail_transaksi', DetailTransaksiController::class);
});


Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', function() {
        return view('admin.dashboard');
    });
    Route::get('/admin/logout', [AuthController::class, 'logoutadmin']);

   
    Route::resource('kasir', KasirController::class);
    Route::resource('barang', BarangController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('supplier', SupplierController::class);
});
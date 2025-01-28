<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailTransaksiController extends Controller
{
    public function index()
    {
        $datadetail = DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.kode_transaksi', '=', 'transaksi.kode_transaksi')
            ->join('barang', 'detail_transaksi.kode_barang', '=', 'barang.kode_barang')
            ->select('detail_transaksi.*', 'barang.nama_barang')
            ->get();
        return view('detail_transaksi.index', compact('datadetail'));
    }

    public function create()
    {
        $transaksi = DB::table('transaksi')->get();
        $barang = DB::table('barang')->get();
        return view('detail_transaksi.create', compact('transaksi', 'barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_transaksi' => 'required|max:6|exists:transaksi,kode_transaksi',
            'kode_barang' => 'required|max:6|exists:barang,kode_barang',
            'qty' => 'required|integer|',
            'total' => 'required|numeric|',
        ]);

        DB::table('detail_transaksi')->insert([
            'kode_transaksi' => $request->kode_transaksi,
            'kode_barang' => $request->kode_barang,
            'qty' => $request->qty,
            'total' => $request->total,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('detail_transaksi.index')
            ->with('success', 'Detail transaksi berhasil ditambahkan');
    }

    public function show($kode_transaksi)
    {
        $detail = DB::table('detail_transaksi')
            ->join('barang', 'detail_transaksi.kode_barang', '=', 'barang.kode_barang')
            ->select('detail_transaksi.*', 'barang.nama_barang')
            ->where('kode_transaksi', $kode_transaksi)
            ->get();
        return view('detail_transaksi.show', compact('detail'));
    }

    public function edit($id)
    {
        $detail = DB::table('detail_transaksi')
            ->where('kode_transaksi', $id)
            ->first();
        $transaksi = DB::table('transaksi')->get();
        $barang = DB::table('barang')->get();
        return view('detail_transaksi.edit', compact('detail', 'transaksi', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|',
            'total' => 'required|numeric|',
        ]);

        DB::table('detail_transaksi')
            ->where('kode_transaksi', $id)
            ->where('kode_barang', $request->kode_barang)
            ->update([
                'qty' => $request->qty,
                'total' => $request->total,
                'updated_at' => now(),
            ]);

        return redirect()->route('detail_transaksi.index')
            ->with('success', 'Detail transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('detail_transaksi')
            ->where('kode_transaksi', $id)
            ->delete();
        return redirect()->route('detail_transaksi.index')
            ->with('success', 'Detail transaksi berhasil dihapus');
    }
}
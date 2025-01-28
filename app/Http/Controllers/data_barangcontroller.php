<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class data_barangcontroller extends Controller
{
    public function index()
    {
        $databarang = DB::table('barang')->get();
        return view('barang.index', compact('databarang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:barang|max:6',
            'nama_barang' => 'required|max:30',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'kode_kategori' => 'required|max:4',
        ]);

        DB::table('barang')->insert([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kode_kategori' => $request->kode_kategori,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $barang = DB::table('barang')->where('kode_barang', $id)->first();
        return view('barang.show', compact('barang'));
    }

    public function edit(string $id)
    {
        $barang = DB::table('barang')->where('kode_barang', $id)->first();
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_barang' => 'required|max:30',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'kode_kategori' => 'required|max:4',
        ]);

        DB::table('barang')
            ->where('kode_barang', $id)
            ->update([
                'nama_barang' => $request->nama_barang,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'kode_kategori' => $request->kode_kategori,
                'updated_at' => now(),
            ]);

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        DB::table('barang')->where('kode_barang', $id)->delete();
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class data_kategoricontroller extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kode_kategori' => 'required|unique:kategori|max:6',
            'nama_kategori' => 'required|max:6',
            'supplier' => 'required|max:20',
        ]);

        DB::table('kategori')->insert([
            'kode_kategori' => $request->kode_kategori,
            'nama_kategori' => $request->nama_kategori,
            'supplier' => $request->supplier,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Data kategori berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:6',
            'supplier' => 'required|max:20',
        ]);

        DB::table('kategori')
            ->where('kode_kategori', $id)
            ->update([
                'nama_kategori' => $request->nama_kategori,
                'supplier' => $request->supplier,
                'updated_at' => now(),
            ]);

        return redirect()->route('kategori.index')
            ->with('success', 'Data kategori berhasil diperbarui');
    }
}

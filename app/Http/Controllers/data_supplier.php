<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kode_supplier' => 'required|unique:supplier|max:6',
            'nama_supplier' => 'required|max:20',  // 
            'kode_barang' => 'required|max:6',
        ]);

        DB::table('supplier')->insert([
            'kode_supplier' => $request->kode_supplier,
            'nama_supplier' => $request->nama_supplier,
            'nohp' => $request->nohp,
            'kode_barang' => $request->kode_barang,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('supplier.index')
            ->with('success', 'Data supplier berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required|max:20',  // Diubah dari 50 ke 20
            'nohp' => 'required|max:13',
            'kode_barang' => 'required|max:6',
        ]);

        DB::table('supplier')
            ->where('kode_supplier', $id)
            ->update([
                'nama_supplier' => $request->nama_supplier,
                'nohp' => $request->nohp,
                'kode_barang' => $request->kode_barang,
                'updated_at' => now(),
            ]);

        return redirect()->route('supplier.index')
            ->with('success', 'Data supplier berhasil diperbarui');
    }

    // ... method lainnya tetap sama ...
}
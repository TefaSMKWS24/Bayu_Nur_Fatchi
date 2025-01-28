<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class data_pelanggancontroller extends Controller
{
    public function index()
    {
        $datapelanggan = DB::table('pelanggan')->get();
        return view('pelanggan.index', compact('datapelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pelanggan' => 'required|unique:pelanggan|max:6',
            'nama_pelanggan' => 'required|max:20',
            'nohp' => 'required|max:13',
        ]);

        DB::table('pelanggan')->insert([
            'kode_pelanggan' => $request->kode_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'nohp' => $request->nohp,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $pelanggan = DB::table('pelanggan')->where('kode_pelanggan', $id)->first();
        return view('pelanggan.show', compact('pelanggan'));
    }

    public function edit(string $id)
    {
        $pelanggan = DB::table('pelanggan')->where('kode_pelanggan', $id)->first();
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|max:20',
            'nohp' => 'required|max:13',
        ]);

        DB::table('pelanggan')
            ->where('kode_pelanggan', $id)
            ->update([
                'nama_pelanggan' => $request->nama_pelanggan,
                'nohp' => $request->nohp,
                'updated_at' => now(),
            ]);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        DB::table('pelanggan')->where('kode_pelanggan', $id)->delete();
        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil dihapus');
    }
}

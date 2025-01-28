<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        $datakasir = DB::table('kasir')->get();
        return view('kasir.index', compact('datakasir'));
    }

    public function create()
    {
        return view('kasir.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_kasir' => 'required|unique:kasir|max:6',
            'nama_kasir' => 'required|max:20',
            'shift_mulai' => 'required',
            'shift_akhir' => 'required',
            'nohp' => 'required|max:13',
        ]);

        DB::table('kasir')->insert([
            'kode_kasir' => $request->kode_kasir,
            'nama_kasir' => $request->nama_kasir,
            'shift_mulai' => $request->shift_mulai,
            'shift_akhir' => $request->shift_akhir,
            'nohp' => $request->nohp,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('kasir.index')
            ->with('success', 'Data kasir berhasil ditambahkan');
    }

    public function show($id)
    {
        $kasir = DB::table('kasir')->where('kode_kasir', $id)->first();
        return view('kasir.show', compact('kasir'));
    }

    public function edit($id)
    {
        $kasir = DB::table('kasir')->where('kode_kasir', $id)->first();
        return view('kasir.edit', compact('kasir'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kasir' => 'required|max:20',
            'shift_mulai' => 'required',
            'shift_akhir' => 'required',
            'nohp' => 'required|max:13',
        ]);

        DB::table('kasir')
            ->where('kode_kasir', $id)
            ->update([
                'nama_kasir' => $request->nama_kasir,
                'shift_mulai' => $request->shift_mulai,
                'shift_akhir' => $request->shift_akhir,
                'nohp' => $request->nohp,
                'updated_at' => now(),
            ]);

        return redirect()->route('kasir.index')
            ->with('success', 'Data kasir berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('kasir')->where('kode_kasir', $id)->delete();
        return redirect()->route('kasir.index')
            ->with('success', 'Data kasir berhasil dihapus');
    }
}
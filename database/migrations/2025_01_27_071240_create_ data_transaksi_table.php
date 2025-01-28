<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $datatransaksi = DB::table('transaksi')
            ->join('kasir', 'transaksi.kode_kasir', '=', 'kasir.kode_kasir')
            ->join('pelanggan', 'transaksi.kode_pelanggan', '=', 'pelanggan.kode_pelanggan')
            ->select('transaksi.*', 'kasir.nama_kasir', 'pelanggan.nama_pelanggan')
            ->get();
        return view('transaksi.index', compact('datatransaksi'));
    }

    public function create()
    {
        $datakasir = DB::table('kasir')->get();
        $datapelanggan = DB::table('pelanggan')->get();
        return view('transaksi.create', compact('datakasir', 'datapelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_transaksi' => 'required|unique:transaksi|max:6',
            'tanggal_transaksi' => 'required|date',
            'kode_kasir' => 'required|max:6|exists:kasir,kode_kasir',
            'kode_pelanggan' => 'required|max:6|exists:pelanggan,kode_pelanggan',
            'kode_voucher' => 'nullable|max:6',
            'diskon' => 'nullable|max:6',
            'total_belanja' => 'required|numeric',
        ]);

        DB::table('transaksi')->insert([
            'kode_transaksi' => $request->kode_transaksi,
            'tanggal_transaksi' => $request->tanggal,
            'kode_kasir' => $request->kode_kasir,
            'kode_pelanggan' => $request->kode_pelanggan,
            'kode_voucher' => $request->kode_voucher,
            'diskon' => $request->diskon,
            'total_belanja' => $request->total_belanja,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil ditambahkan');
    }

    public function show($id)
    {
        $transaksi = DB::table('transaksi')
            ->join('kasir', 'transaksi.kode_kasir', '=', 'kasir.kode_kasir')
            ->join('pelanggan', 'transaksi.kode_pelanggan', '=', 'pelanggan.kode_pelanggan')
            ->select('transaksi.*', 'kasir.nama_kasir', 'pelanggan.nama_pelanggan')
            ->where('kode_transaksi', $id)
            ->first();
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit($id)
    {
        $transaksi = DB::table('transaksi')->where('kode_transaksi', $id)->first();
        $datakasir = DB::table('kasir')->get();
        $datapelanggan = DB::table('pelanggan')->get();
        return view('transaksi.edit', compact('transaksi', 'datakasir', 'datapelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'kode_kasir' => 'required|max:6|exists:kasir,kode_kasir',
            'kode_pelanggan' => 'required|max:6|exists:pelanggan,kode_pelanggan',
            'kode_voucher' => 'nullable|max:6',
            'diskon' => 'nullable|max:6',
            'total_belanja' => 'required|numeric',
        ]);

        DB::table('transaksi')
            ->where('kode_transaksi', $id)
            ->update([
                'tanggal_transaksi' => $request->tanggal,
                'kode_kasir' => $request->kode_kasir,
                'kode_pelanggan' => $request->kode_pelanggan,
                'kode_voucher' => $request->kode_voucher,
                'diskon' => $request->diskon,
                'total_belanja' => $request->total_belanja,
                'updated_at' => now(),
            ]);

        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('transaksi')->where('kode_transaksi', $id)->delete();
        return redirect()->route('transaksi.index')
            ->with('success', 'Data transaksi berhasil dihapus');
    }
}
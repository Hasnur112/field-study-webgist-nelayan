<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebGisController extends Controller
{
    public function beranda()
    {
        $laporan = \App\Models\LaporanNelayan::all();
        $total = $laporan->count();
        $aman = $laporan->where('kategori_zona', 1)->count();
        $rawan = $laporan->where('kategori_zona', 2)->count();
        $larangan = $laporan->where('kategori_zona', 3)->count();

        return view('beranda', compact('total', 'aman', 'rawan', 'larangan'));
    }

    public function index()
    {
        $data_laporan = \App\Models\LaporanNelayan::latest()->get();
        return view('peta', compact('data_laporan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pelapor' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kategori_zona' => 'required|integer|in:1,2,3',
            'keterangan' => 'nullable|string',
        ]);

        \App\Models\LaporanNelayan::create($validatedData);

        return redirect()->back()->with('success', 'Laporan zona berhasil dikirim, Terima kasih!');
    }
}

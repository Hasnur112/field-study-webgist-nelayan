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
        // Ambil data beserta relasi usernya
        $data_laporan = \App\Models\LaporanNelayan::with('user')->latest()->get();
        return view('peta', compact('data_laporan'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'kategori_zona' => 'required|integer|in:1,2,3',
            'keterangan' => 'nullable|string',
        ]);

        // Menyisipkan user_id dari sesi login
        $validatedData['user_id'] = \Illuminate\Support\Facades\Auth::id();

        \App\Models\LaporanNelayan::create($validatedData);

        return redirect()->back()->with('success', 'Laporan zonasi berhasil dikirim. Terima kasih atas partisipasi Anda.');
    }

    public function dashboard()
    {
        $laporan = \App\Models\LaporanNelayan::where('user_id', \Illuminate\Support\Facades\Auth::id())->latest()->get();
        return view('dashboard', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = \App\Models\LaporanNelayan::where('user_id', \Illuminate\Support\Facades\Auth::id())->findOrFail($id);
        
        $validatedData = $request->validate([
            'kategori_zona' => 'required|integer|in:1,2,3',
            'keterangan' => 'nullable|string',
        ]);
        
        $laporan->update($validatedData);
        return redirect()->back()->with('status', 'Data laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $laporan = \App\Models\LaporanNelayan::where('user_id', \Illuminate\Support\Facades\Auth::id())->findOrFail($id);
        $laporan->delete();
        return redirect()->back()->with('status', 'Data laporan berhasil dihapus.');
    }
}

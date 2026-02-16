<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'jumlah_dana' => 'required|numeric',
            'tanggal_dibutuhkan' => 'required|date',
        ]);

        Pengajuan::create([
            'user_id' => Auth()->id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'jumlah_dana' => $request->jumlah_dana,
            'tanggal_dibutuhkan' => $request->tanggal_dibutuhkan,
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim');
    }

    public function index()
    {
            $pengajuans = Pengajuan::where('user_id', Auth()->id())->get();

            return view('dashboard.civitas', compact('pengajuans'));
    }
//
}

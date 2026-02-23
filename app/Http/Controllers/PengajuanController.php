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

    public function approve($id)
    {
        $pengajuan = pengajuan::findOrFail($id);
        $pengajuan->status = 'disetujui_kepsek';
        $pengajuan->save();

        return back();
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->status = 'ditolak';
        $pengajuan->alasan_penolakan = $request->alasan_penolakan;
        $pengajuan->save();

        return back();
    }

    public function indexKepsek()
    {
        $pengajuans = pengajuan::all();
        return view('dashboard.kepsek', compact('pengajuans'));
    }

    public function indexBendahara()
    {
        $pengajuans = pengajuan::where('status', 'disetujui_kepsek')
            ->whereNull('tanggal_pencairan')
            ->get();

        return view('dashboard.bendahara', compact('pengajuans'));
    }

    public function cairkan($id)
    {
        $pengajuan = pengajuan::findOrFail($id);
        $pengajuan->tanggal_pencairan = now();
        $pengajuan->status = 'dicairkan';
        $pengajuan->save();

        return back();
    }
//
}

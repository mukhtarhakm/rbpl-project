<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RKAS;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class RKASController extends Controller
{
    public function create()
    {
        return view('bendahara.rkas-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required',
            'total_anggaran' => 'required|numeric',
        ]);

        $rkas = RKAS::create([
            'user_id' => Auth::id(),
            'tahun_ajaran' => $request->tahun_ajaran,
            'jumlah_dana' => $request->total_anggaran,
            'status' => 'menunggu',
            'deskripsi' => $request->deskripsi ?? 'Rencana kegiatan dan anggaran sekolah tahun ajaran ' . $request->tahun_ajaran,
            'kegiatan_list' => $request->activities ?? [],
        ]);

        // Notifikasi ke semua Kepsek
        $kepseks = \App\Models\User::where('role', 'kepsek')->get();
        foreach ($kepseks as $kepsek) {
            $kepsek->notify(new \App\Notifications\StatusPengajuanUpdated($rkas, 'RKAS Baru (' . $rkas->tahun_ajaran . ') diajukan oleh Bendahara dan butuh persetujuan.'));
        }

        return redirect()->back()->with('success', 'RKAS berhasil dibuat');
    }

    public function index()
    {
        $rkas_list = RKAS::latest()->get();
        
        $total_anggaran = $rkas_list->where('status', 'disetujui')->sum('jumlah_dana');
        
        // Realisasi = Total dana dari pengajuan yang sudah cair atau selesai
        $total_realisasi = Pengajuan::whereIn('status', ['dicairkan', 'selesai'])->sum('jumlah_dana');
        
        $realisasi_persen = $total_anggaran > 0 ? round(($total_realisasi / $total_anggaran) * 100) : 0;
        
        return view('bendahara.rkas-status', compact('rkas_list', 'total_anggaran', 'total_realisasi', 'realisasi_persen'));
    }

    public function show($id)
    {
        $rkas = RKAS::findOrFail($id);
        
        // Ambil pengajuan yang sudah cair untuk RKAS ini
        $pengajuans = Pengajuan::where('rkas_id', $rkas->id)
            ->where('status', 'dicairkan')
            ->get();

        // Hitung realisasi per kegiatan
        if ($rkas->kegiatan_list) {
            $activities = collect($rkas->kegiatan_list)->map(function($item, $index) use ($pengajuans) {
                // Cari total pengeluaran untuk index kegiatan ini
                $item['realisasi'] = $pengajuans->where('kegiatan_idx', $index)->sum('jumlah_dana');
                return $item;
            });
            $rkas->kegiatan_list = $activities->toArray();
        }

        return view('bendahara.rkas-show', compact('rkas'));
    }

    public function approve($id)
    {
        $rkas = RKAS::findOrFail($id);
        $rkas->status = 'disetujui';
        $rkas->save();

        // Notifikasi ke Bendahara pembuat RKAS
        $rkas->user->notify(new \App\Notifications\StatusPengajuanUpdated($rkas, 'RKAS Tahun Ajaran ' . $rkas->tahun_ajaran . ' Anda telah disetujui oleh Kepala Sekolah.'));

        return redirect('/dashboard/kepsek/persetujuan')->with('success', 'RKAS berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required'
        ]);

        $rkas = RKAS::findOrFail($id);
        $rkas->status = 'ditolak';
        $rkas->alasan_penolakan = $request->alasan_penolakan;
        $rkas->save();

        // Notifikasi ke Bendahara pembuat RKAS
        $rkas->user->notify(new \App\Notifications\StatusPengajuanUpdated($rkas, 'RKAS Tahun Ajaran ' . $rkas->tahun_ajaran . ' Anda ditolak: ' . $request->alasan_penolakan));

        return redirect('/dashboard/kepsek/persetujuan')->with('success', 'RKAS berhasil ditolak');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RKAS;
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

        RKAS::create([
            'user_id' => Auth::id(),
            'tahun_ajaran' => $request->tahun_ajaran,
            'jumlah_dana' => $request->total_anggaran,
            'status' => 'menunggu',
            'deskripsi' => $request->deskripsi ?? 'Rencana kegiatan dan anggaran sekolah tahun ajaran ' . $request->tahun_ajaran,
            'kegiatan_list' => $request->activities ?? [],
        ]);

        return redirect()->back()->with('success', 'RKAS berhasil dibuat');
    }

    public function index()
    {
        $rkas_list = RKAS::latest()->get();
        
        // Mock data for overview (in real app, calculate from database)
        $total_anggaran = $rkas_list->where('status', 'disetujui')->sum('jumlah_dana');
        $total_realisasi = $total_anggaran * 0.68; // Mock 68%
        
        return view('bendahara.rkas-status', compact('rkas_list', 'total_anggaran', 'total_realisasi'));
    }

    public function show($id)
    {
        $rkas = RKAS::findOrFail($id);
        
        // Mocking activities realization if not present
        if ($rkas->kegiatan_list) {
            $activities = collect($rkas->kegiatan_list)->map(function($item) {
                // Add a mock 'realisasi' field for the UI
                $item['realisasi'] = ($item['amount'] ?? 0) * (rand(40, 95) / 100);
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

        return back()->with('success', 'RKAS berhasil disetujui');
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

        return back()->with('success', 'RKAS berhasil ditolak');
    }
}

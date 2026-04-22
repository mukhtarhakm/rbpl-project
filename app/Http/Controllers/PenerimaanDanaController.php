<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenerimaanDana;
use App\Models\Pengajuan;

class PenerimaanDanaController extends Controller
{
   public function index()
{
    $penerimaans = PenerimaanDana::latest()->get();
    $totalPenerimaan = PenerimaanDana::sum('jumlah');

    return view('bendahara.penerimaan', compact('penerimaans','totalPenerimaan'));
}

    public function store(Request $request)
    {
        $request->validate([
            'sumber_dana' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_penerimaan' => 'required|date',
        ]);

        PenerimaanDana::create([
            'sumber_dana' =>$request->sumber_dana,
            'jumlah' => $request->jumlah,
            'tanggal_penerimaan' => $request->tanggal_penerimaan,
            'keterangan' => $request->keterangan,
        ]);
        return back()->with('success', 'Dana berhasil ditambahkan');
    }

    public function create()
    {
        return view('bendahara.penerimaan-create');
    }

    public function transaksi()
    {
        $penerimaans = PenerimaanDana::all()->map(function($item) {
            return [
                'tanggal' => $item->tanggal_penerimaan,
                'keterangan' => $item->sumber_dana . ' (' . $item->keterangan . ')',
                'tipe' => 'masuk',
                'jumlah' => $item->jumlah,
            ];
        });

        $pengajuans = Pengajuan::whereIn('status', ['dicairkan', 'selesai'])->get()->map(function($item) {
            return [
                'tanggal' => $item->tanggal_pencairan ?? $item->updated_at,
                'keterangan' => $item->judul,
                'tipe' => 'keluar',
                'jumlah' => $item->jumlah_dana,
            ];
        });

        $semuaTransaksi = $penerimaans->concat($pengajuans)->sortByDesc('tanggal');

        return view('bendahara.transaksi', compact('semuaTransaksi'));
    }
}

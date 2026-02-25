<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenerimaanDana;

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
            'jumlah' => 'required|numeric',
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
}

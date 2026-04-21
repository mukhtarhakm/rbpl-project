<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\RKAS;
use App\Models\PenerimaanDana;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengajuan::whereIn('status', ['dicairkan', 'selesai']);

        // Gunakan when() agar lebih clean dan pasti masuk rutenya
        $query->when($request->filled('month'), function($q) use ($request) {
            $q->whereMonth('tanggal_pencairan', $request->month);
        });

        $query->when($request->filled('rkas_id'), function($q) use ($request) {
            $q->where('rkas_id', $request->rkas_id);
        });

        $transaksi = $query->latest('tanggal_pencairan')->get();
        $rkas_list = RKAS::orderBy('tahun_ajaran', 'desc')->get();
        $total_pengeluaran = $transaksi->sum('jumlah_dana');

        return view('reports.keuangan', compact('transaksi', 'rkas_list', 'total_pengeluaran'));
    }

    public function downloadPDF(Request $request)
    {
        $query = Pengajuan::whereIn('status', ['dicairkan', 'selesai']);

        $query->when($request->filled('month'), function($q) use ($request) {
            $q->whereMonth('tanggal_pencairan', $request->month);
        });

        $query->when($request->filled('rkas_id'), function($q) use ($request) {
            $q->where('rkas_id', $request->rkas_id);
        });

        $transaksi = $query->latest('tanggal_pencairan')->get();
        $rkas_aktif = $request->filled('rkas_id') ? RKAS::find($request->rkas_id) : RKAS::where('status', 'disetujui')->latest()->first();
        
        $data = [
            'transaksi' => $transaksi,
            'rkas' => $rkas_aktif,
            'month' => $request->month,
            'total' => $transaksi->sum('jumlah_dana'),
            'date' => date('d/m/Y')
        ];

        $pdf = Pdf::loadView('reports.pdf_template', $data);
        
        $filename = 'Laporan_Keuangan_' . ($request->month ? 'Bulan_'.$request->month.'_' : '') . date('Ymd') . '.pdf';
        return $pdf->download($filename);
    }
}

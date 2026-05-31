<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\RKAS;
use App\Models\PenerimaanDana;
use App\Models\User;
use App\Notifications\StatusPengajuanUpdated;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    public function create()
    {
        $rkas_list = RKAS::where('status', 'disetujui')->latest()->get();
        return view('civitas.ajukan', compact('rkas_list'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'jumlah_dana' => 'required|numeric|min:1',
            'tanggal_dibutuhkan' => 'required|date',
            'rkas_id' => 'nullable|exists:rkas,id',
            'kegiatan_idx' => 'nullable',
        ]);

        // Cek sisa anggaran di RKAS jika ada rkas_id
        if ($request->rkas_id && $request->kegiatan_idx !== null) {
            $rkas = RKAS::findOrFail($request->rkas_id);
            
            // Pastikan RKAS sudah disetujui
            if ($rkas->status !== 'disetujui') {
                return back()->withErrors(['rkas_id' => 'Hanya bisa mengajukan dana untuk RKAS yang sudah disetujui.'])->withInput();
            }

            // Pastikan kegiatan_idx valid
            if (!isset($rkas->kegiatan_list[$request->kegiatan_idx])) {
                return back()->withErrors(['kegiatan_idx' => 'Kategori kegiatan tidak valid.'])->withInput();
            }

            $remaining = $rkas->getRemainingBudget($request->kegiatan_idx);
            
            if ($request->jumlah_dana > $remaining) {
                return back()->withErrors(['jumlah_dana' => 'Jumlah pengajuan melebihi sisa anggaran (Sisa: Rp ' . number_format($remaining, 0, ',', '.') . ')'])->withInput();
            }
        }

        $pengajuan = Pengajuan::create([
            'user_id' => Auth::id(),
            'rkas_id' => $request->rkas_id,
            'kegiatan_idx' => $request->kegiatan_idx,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'jumlah_dana' => $request->jumlah_dana,
            'tanggal_dibutuhkan' => $request->tanggal_dibutuhkan,
            'status' => 'menunggu',
        ]);

        // Notifikasi ke semua Kepsek
        $kepseks = \App\Models\User::where('role', 'kepsek')->get();
        foreach ($kepseks as $kepsek) {
            $kepsek->notify(new \App\Notifications\StatusPengajuanUpdated($pengajuan, 'Ada pengajuan dana baru dari ' . Auth::user()->name . ' (' . $pengajuan->judul . ') yang butuh persetujuan.'));
        }

        return redirect('/pengajuan/create')->with('success', 'Pengajuan berhasil dikirim');
    }

    public function index()
    {
        $user = Auth::user();
        $pengajuans = Pengajuan::where('user_id', $user->id)->latest()->get();

        // Calculate statistics
        $aktif = $pengajuans->where('status', 'menunggu')->count();
        $disetujui = $pengajuans->whereIn('status', ['disetujui_kepsek', 'dicairkan', 'selesai'])->count();
        $totalDana = $pengajuans->whereIn('status', ['disetujui_kepsek', 'dicairkan', 'selesai'])->sum('jumlah_dana');

        // Fetch notifications
        $notifications = $user->unreadNotifications;

        return view('dashboard.civitas', compact('pengajuans', 'aktif', 'disetujui', 'totalDana', 'notifications'));
    }

    public function approve($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        
        if ($pengajuan->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Hanya pengajuan berstatus menunggu yang bisa disetujui.');
        }

        $pengajuan->status = 'disetujui_kepsek';
        $pengajuan->save();

        // Notifikasi ke pembuat pengajuan (Civitas)
        $pengajuan->user->notify(new StatusPengajuanUpdated($pengajuan, 'Pengajuan dana Anda telah disetujui oleh Kepala Sekolah.'));

        // Notifikasi ke semua Bendahara (biar mereka tahu ada yang siap dicairkan)
        $bendaharas = User::where('role', 'bendahara')->get();
        foreach ($bendaharas as $bendahara) {
            $bendahara->notify(new StatusPengajuanUpdated($pengajuan, 'Ada pengajuan baru (' . $pengajuan->judul . ') yang disetujui Kepsek dan siap dicairkan.'));
        }

        return redirect('/dashboard/kepsek/persetujuan')->with('success', 'Pengajuan berhasil disetujui');
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

        // Send Notification
        $pengajuan->user->notify(new StatusPengajuanUpdated($pengajuan, 'Pengajuan dana Anda ditolak: ' . $request->alasan_penolakan));

        return redirect('/dashboard/kepsek/persetujuan')->with('success', 'Pengajuan berhasil ditolak');
    }

    public function indexKepsek()
    {
        // 1. Tugas Menunggu (RKAS + Pengajuan)
        $rkas_menunggu = RKAS::where('status', 'menunggu')->latest()->get();
        $pengajuan_menunggu = Pengajuan::where('status', 'menunggu')->latest()->get();
        $count_menunggu = $rkas_menunggu->count() + $pengajuan_menunggu->count();

        // 2. Jumlah Pengajuan Disetujui (Kepsek Approved)
        $jumlah_disetujui = Pengajuan::whereIn('status', ['disetujui_kepsek', 'dicairkan', 'selesai'])->count();

        // 3. Total Pagu Anggaran (Dari RKAS Aktif)
        $rkas_aktif = RKAS::where('status', 'disetujui')->latest()->first();
        $total_pagu = $rkas_aktif ? $rkas_aktif->jumlah_dana : 0;

        // 4. Realisasi Dana (Total yang sudah dicairkan/selesai)
        $total_realisasi = Pengajuan::whereIn('status', ['dicairkan', 'selesai'])->sum('jumlah_dana');

        // Untuk list bawah
        $pengajuans = Pengajuan::latest()->get(); 
        $rkas_list = RKAS::where('status', 'menunggu')->get();

        // Ambil Notifikasi
        $notifications = auth()->user()->unreadNotifications;

        return view('dashboard.kepsek', compact(
            'pengajuans', 
            'rkas_list', 
            'count_menunggu', 
            'jumlah_disetujui', 
            'total_pagu', 
            'total_realisasi',
            'notifications'
        ));
    }

    public function indexBendahara()
    {
        $pengajuans = Pengajuan::where('status', 'disetujui_kepsek')
            ->whereNull('tanggal_pencairan')
            ->get();

        $totalMasuk = PenerimaanDana::sum('jumlah');
        $totalKeluar = Pengajuan::whereIn('status', ['dicairkan', 'selesai'])->sum('jumlah_dana');
        $totalSaldo = $totalMasuk - $totalKeluar;

        // Fetch notifications for Treasurer
        $notifications = auth()->user()->unreadNotifications;

        return view('dashboard.bendahara', compact('pengajuans', 'totalMasuk', 'totalKeluar', 'totalSaldo', 'notifications'));
    }

    public function cairkan($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        
        if ($pengajuan->status !== 'disetujui_kepsek') {
            return redirect()->back()->with('error', 'Hanya pengajuan yang sudah disetujui Kepsek yang bisa dicairkan.');
        }

        // Cek ketersediaan saldo kas
        $availableBalance = PenerimaanDana::getAvailableBalance();
        if ($pengajuan->jumlah_dana > $availableBalance) {
            return redirect()->back()->with('error', 'Saldo kas tidak mencukupi untuk pencairan ini (Tersedia: Rp ' . number_format($availableBalance, 0, ',', '.') . ')');
        }

        \DB::transaction(function() use ($pengajuan) {
            $pengajuan->status = 'dicairkan';
            $pengajuan->tanggal_pencairan = now();
            $pengajuan->save();

            // Notifikasi ke pembuat pengajuan
            $user = $pengajuan->user;
            $user->notify(new StatusPengajuanUpdated($pengajuan, 'Dana pengajuan Anda telah dicairkan oleh Bendahara.'));
        });

        return redirect()->back()->with('success', 'Dana berhasil dicairkan');
    }

    public function realisasiLangsung(Request $request)
    {
        $request->validate([
            'rkas_id' => 'required|exists:rkas,id',
            'kegiatan_idx' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'required',
        ]);

        $rkas = RKAS::findOrFail($request->rkas_id);
        
        // Pastikan RKAS sudah disetujui
        if ($rkas->status !== 'disetujui') {
            return back()->with('error', 'Hanya bisa mencatat realisasi untuk RKAS yang sudah disetujui.');
        }

        // Pastikan kegiatan_idx valid
        if (!isset($rkas->kegiatan_list[$request->kegiatan_idx])) {
            return back()->with('error', 'Kategori kegiatan tidak valid.');
        }

        // Cek Budget
        $remaining = $rkas->getRemainingBudget($request->kegiatan_idx);
        if ($request->jumlah > $remaining) {
            return back()->with('error', 'Jumlah melebihi sisa anggaran (Sisa: Rp ' . number_format($remaining, 0, ',', '.') . ')');
        }

        // Cek Saldo Kas
        $availableBalance = PenerimaanDana::getAvailableBalance();
        if ($request->jumlah > $availableBalance) {
            return back()->with('error', 'Saldo kas tidak mencukupi (Tersedia: Rp ' . number_format($availableBalance, 0, ',', '.') . ')');
        }

        $kegiatan = $rkas->kegiatan_list[$request->kegiatan_idx];

        Pengajuan::create([
            'user_id' => Auth::id(),
            'rkas_id' => $request->rkas_id,
            'kegiatan_idx' => $request->kegiatan_idx,
            'judul' => 'Realisasi Langsung: ' . $kegiatan['name'],
            'deskripsi' => $request->keterangan,
            'jumlah_dana' => $request->jumlah,
            'tanggal_dibutuhkan' => now(),
            'tanggal_pencairan' => now(),
            'status' => 'selesai', // Langsung selesai
        ]);

        return redirect()->back()->with('success', 'Realisasi berhasil dicatat');
    }

    public function pencairanList()
    {
        $siap_cair = Pengajuan::where('status', 'disetujui_kepsek')
            ->whereNull('tanggal_pencairan')
            ->latest()
            ->get();
            
        $sudah_cair = Pengajuan::whereIn('status', ['dicairkan', 'selesai'])
            ->latest()
            ->get();

        return view('bendahara.pencairan', compact('siap_cair', 'sudah_cair'));
    }

    public function pencairanDetail($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        return view('bendahara.pencairan-detail', compact('pengajuan'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pengajuan = Pengajuan::where('user_id', Auth::id())->findOrFail($id);

        if ($pengajuan->status !== 'dicairkan') {
            return redirect()->back()->with('error', 'Hanya bisa upload bukti untuk pengajuan yang sudah dicairkan.');
        }

        $file = $request->file('bukti');
        $namafile = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/bukti', $namafile);

        $pengajuan->bukti_pengeluaran = $namafile;
        $pengajuan->status = 'selesai';
        $pengajuan->save();

        // Notifikasi ke semua Bendahara
        $bendaharas = User::where('role', 'bendahara')->get();
        foreach ($bendaharas as $bendahara) {
            $bendahara->notify(new StatusPengajuanUpdated($pengajuan, 'Bukti pengeluaran baru telah diupload untuk: ' . $pengajuan->judul));
        }

        return redirect('/civitas/upload-bukti')->with('success_upload', 'Bukti pengeluaran berhasil diupload');
    }

    public function uploadBuktiList()
    {
        $pengajuans = Pengajuan::where('user_id', auth()->id())
            ->where('status', 'dicairkan')
            ->latest()
            ->get();

        return view('civitas.upload-list', compact('pengajuans'));
    }

    public function uploadBuktiForm($id)
    {
        $pengajuan = Pengajuan::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        return view('civitas.upload-form', compact('pengajuan'));
    }

    public function persetujuan()
    {
        $pengajuans = Pengajuan::where('status', 'menunggu')
                        ->latest()
                        ->get();

        $rkas_list = RKAS::where('status', 'menunggu')
                        ->latest()
                        ->get();

        return view('kepsek.persetujuan', compact('pengajuans', 'rkas_list'));
    }

    public function riwayat()
    {
        $pengajuans = \App\Models\Pengajuan::where('user_id', auth()->id())
                            ->latest()
                            ->get();

        return view('civitas.riwayat', compact('pengajuans'));
    }

    public function persetujuanDetail($type, $id)
    {
        if ($type === 'pengajuan') {
            $item = Pengajuan::findOrFail($id);
        } else {
            $item = RKAS::findOrFail($id);
        }

        return view('kepsek.persetujuan-detail', compact('item', 'type'));
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->get();
        auth()->user()->unreadNotifications->markAsRead();

        return view('civitas.notifications', compact('notifications'));
    }

    public function notificationHistory()
    {
        $user = auth()->user();
        $notifications = $user->notifications; // Ambil semua (read + unread)
        
        // Tandai semua sebagai dibaca saat masuk ke halaman riwayat
        $user->unreadNotifications->markAsRead();

        return view('kepsek.notifikasi', compact('notifications'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\RKAS;
use App\Models\User;
use App\Notifications\StatusPengajuanUpdated;
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
        $pengajuan->status = 'disetujui_kepsek';
        $pengajuan->save();

        // Send Notification
        $pengajuan->user->notify(new StatusPengajuanUpdated($pengajuan, 'Pengajuan dana Anda telah disetujui oleh Kepala Sekolah.'));

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
        $pengajuans = Pengajuan::all();
        $rkas_list = RKAS::where('status', 'menunggu')->get();
        return view('dashboard.kepsek', compact('pengajuans', 'rkas_list'));
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
        $pengajuan = Pengajuan::findOrFail($id);
        $pengajuan->tanggal_pencairan = now();
        $pengajuan->status = 'dicairkan';
        $pengajuan->save();

        // Send Notification
        $pengajuan->user->notify(new StatusPengajuanUpdated($pengajuan, 'Dana pengajuan Anda telah dicairkan oleh Bendahara.'));

        return redirect('/pencairan')->with('success', 'Dana pengajuan berhasil dicairkan. Status telah diupdate.');
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

        $pengajuan = Pengajuan::findOrFail($id);

        $file = $request->file('bukti');
        $namafile = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/bukti', $namafile);

        $pengajuan->bukti_pengeluaran = $namafile;
        $pengajuan->status = 'selesai';
        $pengajuan->save();

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
}

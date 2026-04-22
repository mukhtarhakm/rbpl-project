<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pengajuan;

class RKAS extends Model
{
    use HasFactory;

    protected $table = 'rkas';

    protected $fillable = [
        'user_id',
        'tahun_ajaran',
        'jumlah_dana',
        'status',
        'alasan_penolakan',
        'deskripsi',
        'kegiatan_list',
    ];

    protected $casts = [
        'kegiatan_list' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Menghitung sisa anggaran untuk kegiatan tertentu.
     */
    public function getRemainingBudget($index)
    {
        if (!isset($this->kegiatan_list[$index])) {
            return 0;
        }

        $total_budget = $this->kegiatan_list[$index]['amount'];
        
        // Hitung pengajuan yang sudah disetujui_kepsek, dicairkan, atau selesai
        $spent = Pengajuan::where('rkas_id', $this->id)
            ->where('kegiatan_idx', $index)
            ->whereIn('status', ['disetujui_kepsek', 'dicairkan', 'selesai'])
            ->sum('jumlah_dana');

        return $total_budget - $spent;
    }

    /**
     * Menghitung total realisasi untuk RKAS ini (yang sudah dicairkan atau selesai)
     */
    public function getTotalRealisasi()
    {
        return Pengajuan::where('rkas_id', $this->id)
            ->whereIn('status', ['dicairkan', 'selesai'])
            ->sum('jumlah_dana');
    }

    /**
     * Menghitung persentase realisasi untuk RKAS ini
     */
    public function getRealisasiPersen()
    {
        if ($this->jumlah_dana <= 0) return 0;
        return round(($this->getTotalRealisasi() / $this->jumlah_dana) * 100);
    }
}

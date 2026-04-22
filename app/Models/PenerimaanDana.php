<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pengajuan;

class PenerimaanDana extends Model
{
    use HasFactory;

    protected $fillable =[
        'sumber_dana',
        'jumlah',
        'tanggal_penerimaan',
        'keterangan',
    ];

    /**
     * Menghitung sisa saldo kas sekolah (Total Masuk - Total Keluar).
     */
    public static function getAvailableBalance()
    {
        $totalMasuk = self::sum('jumlah');
        $totalKeluar = Pengajuan::whereIn('status', ['dicairkan', 'selesai'])->sum('jumlah_dana');
        
        return $totalMasuk - $totalKeluar;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rkas_id',
        'kegiatan_idx',
        'judul',
        'deskripsi',
        'jumlah_dana',
        'tanggal_dibutuhkan',
        'status',
        'tanggal_pencairan',
        'bukti_pencairan',
    ];

    protected $casts = [
        'tanggal_pencairan' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rkas()
    {
        return $this->belongsTo(RKAS::class, 'rkas_id');
    }
}

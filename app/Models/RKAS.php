<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}

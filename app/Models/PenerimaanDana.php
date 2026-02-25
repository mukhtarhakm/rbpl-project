<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanDana extends Model
{
    use HasFactory;

    protected $fillable =[
        'sumber_dana',
        'jumlah',
        'tanggal_penerimaan',
        'keterangan',
    ];
}

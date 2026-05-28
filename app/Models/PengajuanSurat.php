<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSurat extends Model
{
    protected $fillable = [
        'nama_opd',
        'perihal',
        'tanggal_acara',
        'jam_mulai',
        'jam_selesai',
        'file_surat',
    ];

    protected $guarded = ['id'];
}

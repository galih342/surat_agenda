<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanSurat extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nama_opd',
        'perihal',
        'tanggal_acara',
        'jam_mulai',
        'jam_selesai',
        'file_surat',
        'status',
        'deleted_at',
    ];

    protected $guarded = ['id'];
}

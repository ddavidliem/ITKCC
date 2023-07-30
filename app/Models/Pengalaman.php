<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Pengalaman extends Model
{
    use UUID;
    use HasFactory;

    protected $fillable = [
        'nama_perusahaan',
        'jabatan',
        'tahun_masuk',
        'tahun_keluar',
        'user_id',
    ];
}

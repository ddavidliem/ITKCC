<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Approval extends Model
{
    use UUID;
    use HasFactory;

    protected $fillable = [
        'username',
        'password',
        'nama_perusahaan',
        'alamat',
        'provinsi',
        'kota',
        'kode_pos',
        'website',
        'bidang_perusahaan',
        'tahun_berdiri',
        'kantor_pusat',
        'nama_lengkap',
        'jabatan',
        'nomor_telepon',
        'alamat_email',
        'formulir',
        'status',
        'feedback',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

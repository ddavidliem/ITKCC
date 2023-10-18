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
        'title',
        'jenis_pekerjaan',
        'organisasi',
        'lokasi_pekerjaan',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
        'user_id',
    ];
}

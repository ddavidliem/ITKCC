<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    use UUID;
    use HasFactory;

    protected $fillable = [
        'bidang_sertifikasi',
        'level',
        'nomor',
        'lembaga_sertifikasi',
        'judul_sertifikasi',
        'user_id',
    ];
}

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
        'title',
        'organisasi',
        'tanggal_terbit',
        'tanggal_berakhir',
        'id_sertifikat',
        'url_sertifikat',
        'user_id',
    ];
}

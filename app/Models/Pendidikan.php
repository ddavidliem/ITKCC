<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Pendidikan extends Model
{
    use UUID;
    use HasFactory;
    protected $fillable = [
        'gelar_pendidikan',
        'nama_organisasi',
        'bidang_studi',
        'tanggal_mulai',
        'tanggal_lulus',
        'user_id',
    ];
}

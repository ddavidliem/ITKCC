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
        'tingkat',
        'nama_instansi',
        'tahun_lulus',
        'user_id',
    ];
}

<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        'program_studi',
        'jurusan',
        'fakultas',
    ];
}

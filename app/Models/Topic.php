<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    use UUID;

    protected $fillable = [
        'topik',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'topik', 'topik');
    }
}

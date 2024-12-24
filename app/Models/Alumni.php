<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    protected $fillable = [
        'name', 'contact', 'photo', 'jurusan', 'angkatan', 'tahun_lulus', 'melanjutkan',
        'pekerjaan', 'perusahaan'
    ];
}

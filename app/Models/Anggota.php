<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = [
        'user_id',
        'alamat',
        'latitude',
        'longitude',
        'kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'no_wa',
        'tahun_masuk_kuliah',
        'jurusan_id',
        'tahun_lk1',
        'tahun_lk2',
        'cabang_lk2',
        'tahun_lk3',
        'badko_lk3',
        'tahun_lkk',
        'cabang_lkk',
        'prestasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function komisariat()
    {
        return $this->belongsTo(Komisariat::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}

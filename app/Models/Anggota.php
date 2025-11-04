<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'foto',
        'alamat',
        'kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'no_wa',
        'tahun_masuk_kuliah',
        'jurusan_id',
        'tahun_lk1',
        'komisariat_id',
        'tahun_lk2',
        'cabang_lk2',
        'tahun_lk3',
        'badko_lk3',
        'tahun_lkk',
        'cabang_lkk',
        'prestasi',
        'latitude',
        'longitude',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'anggota_id');
    }
    

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

     // Relasi ke Komisariat
     public function komisariat()
     {
         return $this->belongsTo(Komisariat::class);
     }
}

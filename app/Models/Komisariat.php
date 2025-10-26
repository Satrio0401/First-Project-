<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Komisariat extends Model
{
    protected $fillable = [
        'nama',
    ];
    public function anggotas()
    {
        return $this->hasMany(Anggota::class);
    }
}

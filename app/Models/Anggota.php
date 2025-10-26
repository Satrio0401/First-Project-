<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = [
        'nama',
        'komisariat_id',
        'alamat',
        'latitude',
        'longitude',
        'foto',
    ];
    public function komisariat()
    {
        return $this->belongsTo(Komisariat::class);
    }

}

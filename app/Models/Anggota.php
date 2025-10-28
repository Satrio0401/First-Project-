<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $fillable = [
        'nama',
        'user_id',
        'alamat',
        'latitude',
        'longitude',
        'foto',
    ];
    public function komisariat()
    {
        return $this->belongsTo(Komisariat::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

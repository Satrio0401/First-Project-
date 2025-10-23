<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SejarahPengurus extends Model
{
    protected $fillable = [
        'periode_mulai',
        'periode_berakhir',
        'ketua',
        'wakil_ketua',
        'order_column',
    ];
}

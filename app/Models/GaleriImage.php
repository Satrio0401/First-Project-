<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriImage extends Model
{
    protected $fillable = [
        'galeri_id',
        'path',
    ];
    public function galeri(): BelongsTo
    {
        return $this->belongsTo(Galeri::class);
    }
}

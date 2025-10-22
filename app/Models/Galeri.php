<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Galeri extends Model
{
    protected $fillable = [
        'judul',
    ];
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::deleting(function (Galeri $galeri) {
            $galeri->images()->each(function ($image) {
                $image->delete();
            });
        });
    }
    public function images(): HasMany
    {
        return $this->hasMany(GaleriImage::class);
    }

    public function firstImage()
    {
        return $this->hasOne(GaleriImage::class)->oldestOfMany();
    }
}

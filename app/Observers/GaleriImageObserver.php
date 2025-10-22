<?php

namespace App\Observers;

use App\Models\GaleriImage;
use Illuminate\Support\Facades\Storage;

class GaleriImageObserver
{

    /**
     * Handle the GaleriImage "deleted" event.
     */
    public function deleted(GaleriImage $galeriImage): void
    {
        if ($galeriImage->path) {
            Storage::disk('public')->delete($galeriImage->path);
        }
    }
}

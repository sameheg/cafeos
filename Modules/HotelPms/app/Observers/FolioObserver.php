<?php

namespace Modules\HotelPms\Observers;

use Modules\HotelPms\Events\FolioPosted;
use Modules\HotelPms\Models\Folio;

class FolioObserver
{
    public function created(Folio $folio): void
    {
        if ($folio->status === Folio::STATUS_POSTED) {
            FolioPosted::dispatch($folio);
        }
    }

    public function updated(Folio $folio): void
    {
        if ($folio->wasChanged('status') && $folio->status === Folio::STATUS_POSTED) {
            FolioPosted::dispatch($folio);
        }
    }
}

<?php

namespace Modules\HotelPms\Adapters;

interface PmsAdapterInterface
{
    public function syncReservations(): int;
}

<?php

namespace Modules\HotelPms\Adapters;

class DummyPmsAdapter implements PmsAdapterInterface
{
    public function syncReservations(): int
    {
        return 0;
    }
}

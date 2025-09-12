<?php

namespace Modules\EventManagement\Enums;

enum TicketStatus: string
{
    case BOOKED = 'booked';
    case SOLD = 'sold';
    case ATTENDED = 'attended';
    case REFUNDED = 'refunded';
}

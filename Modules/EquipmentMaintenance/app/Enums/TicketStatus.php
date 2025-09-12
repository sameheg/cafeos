<?php

namespace Modules\EquipmentMaintenance\Enums;

enum TicketStatus: string
{
    case Scheduled = 'scheduled';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Delayed = 'delayed';
}

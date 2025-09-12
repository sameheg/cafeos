<?php

namespace Modules\SuperAdmin\Enums;

enum ModuleFlagState: string
{
    case Active = 'active';
    case Suspended = 'suspended';
    case Killed = 'killed';
}

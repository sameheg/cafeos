<?php

namespace Modules\Franchise\Enums;

enum TemplateState: string
{
    case Local = 'Local';
    case Synced = 'Synced';
    case Overridden = 'Overridden';
    case Audited = 'Audited';
}

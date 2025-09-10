<?php

namespace Modules\Notifications\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Notifications\Models\Notification;

class NotificationPolicy extends BasePolicy
{
    protected static string $model = Notification::class;
}

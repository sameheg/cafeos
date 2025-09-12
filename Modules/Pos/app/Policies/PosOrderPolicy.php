<?php

namespace Modules\Pos\Policies;

use App\Models\User;
use Modules\Pos\Models\PosOrder;

class PosOrderPolicy {
    public function view(User $user, PosOrder $order): bool { return $user->tenant_id === $order->tenant_id; }
    public function update(User $user, PosOrder $order): bool { return $user->hasPermissionTo('pos.order.update') && $user->tenant_id === $order->tenant_id; }
    public function refund(User $user, PosOrder $order): bool { return $user->hasPermissionTo('pos.order.refund') && $user->tenant_id === $order->tenant_id; }
    public function discount(User $user, PosOrder $order): bool { return $user->hasPermissionTo('pos.order.discount') && $user->tenant_id === $order->tenant_id; }
    public function pay(User $user, PosOrder $order): bool { return $user->hasPermissionTo('pos.order.pay') && $user->tenant_id === $order->tenant_id; }
}

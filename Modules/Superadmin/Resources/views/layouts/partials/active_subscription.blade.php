@php
    $tenant = app('tenant');
    $subscription = $tenant ? \Modules\Superadmin\Entities\Subscription::with('plan')->where('tenant_id', $tenant->id)->latest()->first() : null;
@endphp
@if($subscription)
    <span class="badge bg-success">{{ $subscription->plan->name }}</span>
@else
    <a href="{{ route('superadmin.pricing') }}" class="btn btn-sm btn-primary">Choose Plan</a>
@endif

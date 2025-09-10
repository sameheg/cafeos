<ul>
@foreach($subscriptions as $subscription)
    <li>{{ $subscription->name }} - {{ $subscription->plan->name ?? '' }}</li>
@endforeach
</ul>

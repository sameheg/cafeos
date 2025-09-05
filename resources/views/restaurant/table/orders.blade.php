@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('restaurant.table') #{{ $tableId }}</h1>
    <ul id="table-orders" class="tw-mt-4"></ul>
</div>
@endsection

@section('javascript')
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('/restaurant/tables/{{ $tableId }}/orders')
        .then(response => response.json())
        .then(data => {
            const list = document.getElementById('table-orders');
            data.orders.forEach(function(order) {
                const li = document.createElement('li');
                li.textContent = 'Order #' + order.id + ' - ' + order.status;
                list.appendChild(li);
            });
        });
});
</script>
@endsection

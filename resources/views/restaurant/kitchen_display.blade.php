@extends('layouts.restaurant')
@section('title', __('restaurant.kitchen'))

@section('content')
<section class="no-print p-4" id="kds">
    <div class="flex justify-end mb-4 space-x-2">
        <select id="orientationSelect" class="border rounded px-2 py-1">
            <option value="landscape">Landscape</option>
            <option value="portrait">Portrait</option>
        </select>
        <button id="fullscreenBtn" class="bg-blue-500 text-white px-2 py-1 rounded">
            {{ __('lang_v1.full_screen') }}
        </button>
    </div>
    <div id="orders_div" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($orders as $order)
            <div class="order_div" data-order-id="{{ $order->id }}">
                <div class="bg-gray-200 p-4 rounded text-center">
                    <h4 class="font-semibold">#{{ $order->transaction->invoice_no ?? '' }}</h4>
                    <div class="order_timer" data-start="{{ $order->created_at }}"></div>
                    <div class="status">{{ $order->status }}</div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <h4 class="text-center">@lang('restaurant.no_orders_found')</h4>
            </div>
        @endforelse
    </div>
</section>
@endsection

@section('javascript')
<script>
    function initTimers(){
        document.querySelectorAll('.order_timer').forEach(function(el){
            var start = new Date(el.dataset.start);
            function update(){
                var diff = Math.floor((new Date() - start)/1000);
                var minutes = Math.floor(diff/60);
                var seconds = diff % 60;
                el.textContent = minutes + ':' + ('0'+seconds).slice(-2);
            }
            update();
            setInterval(update,1000);
        });
    }
    initTimers();

    const fullscreenBtn = document.getElementById('fullscreenBtn');
    if (fullscreenBtn) {
        fullscreenBtn.addEventListener('click', function () {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(() => {});
            } else {
                document.exitFullscreen().catch(() => {});
            }
        });
    }

    const orientationSelect = document.getElementById('orientationSelect');
    if (orientationSelect && screen.orientation && screen.orientation.lock) {
        orientationSelect.addEventListener('change', function () {
            screen.orientation.lock(this.value).catch(() => {});
        });
    }
    if (typeof Echo !== 'undefined') {
        Echo.channel('kitchen-orders')
            .listen('KitchenOrderStatusUpdated', function(e){
                var card = document.querySelector('[data-order-id="'+e.orderId+'"]');
                if(card){
                    var statusEl = card.querySelector('.status');
                    statusEl.textContent = e.status;
                }
            });
    } else {
        setInterval(function(){
            axios.get('/modules/orders/status')
                .then(function(resp){
                    resp.data.forEach(function(item){
                        var card = document.querySelector('[data-order-id="'+item.id+'"]');
                        if(card){
                            card.querySelector('.status').textContent = item.status;
                        }
                    });
                });
        }, 5000);
    }
</script>
@endsection

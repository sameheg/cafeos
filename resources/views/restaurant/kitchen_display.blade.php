@extends('layouts.restaurant')
@section('title', __('restaurant.kitchen'))

@section('content')
<section class="content no-print">
    <div class="row" id="orders_div">
        @forelse($orders as $order)
            <div class="col-md-3 col-xs-6 order_div" data-order-id="{{ $order->id }}">
                <div class="small-box bg-gray">
                    <div class="inner text-center">
                        <h4>#{{ $order->transaction->invoice_no ?? '' }}</h4>
                        <div class="order_timer" data-start="{{ $order->created_at }}"></div>
                        <div class="status">{{ $order->status }}</div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
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

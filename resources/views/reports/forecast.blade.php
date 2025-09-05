@extends('layouts.app')
@section('title', __('Forecasted Demand'))

@section('content')
<section class="content-header no-print">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('Forecasted Demand')</h1>
</section>

<section class="content no-print">
    <div class="row">
        <div class="col-12">
            @component('components.widget', ['class' => 'box-primary'])
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>@lang('product.product')</th>
                                <th>@lang('report.current_stock')</th>
                                <th>@lang('report.forecasted_demand')</th>
                                <th>@lang('report.suggested_purchase_qty')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($forecasts as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->current_stock }}</td>
                                    <td>{{ $item->forecast_quantity }}</td>
                                    <td>
                                        @if($item->forecast_quantity > $item->current_stock)
                                            <span class="text-danger">{{ $item->forecast_quantity - $item->current_stock }}</span>
                                        @else
                                            0
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endcomponent
        </div>
    </div>
</section>
@endsection

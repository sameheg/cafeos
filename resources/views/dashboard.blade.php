@extends('layouts.guest')

@section('title', 'Dashboard')

@section('content')
<div id='metrics'>
    <div id='total-sales'>Total Sales: {{ $totalSales }}</div>
    <div id='total-purchases'>Total Purchases: {{ $totalPurchases }}</div>
    <div id='customer-count'>Customers: {{ $customerCount }}</div>
    <div id='product-count'>Products: {{ $productCount }}</div>
</div>
<div id='chart-container'>
    {!! $chart->container() !!}
</div>
@endsection

@section('javascript')
{!! $chart->script() !!}
@endsection

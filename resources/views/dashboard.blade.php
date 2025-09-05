@extends('layouts.guest')

@section('title', 'Dashboard')

@section('content')
<div id="dashboard-widgets">
    @foreach ($widgets as $widget)
        @include('dashboard.widgets.' . str_replace('-', '_', $widget))
    @endforeach
</div>
@endsection

@section('javascript')
{!! $chart->script() !!}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="{{ asset('js/dashboard.js?v=' . $asset_v) }}"></script>
@endsection

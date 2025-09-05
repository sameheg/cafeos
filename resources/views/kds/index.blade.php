@extends('layouts.app')

@section('title', 'KDS')

@section('content')
<div id="kds-app">
    <ticket-board></ticket-board>
</div>
@endsection

@push('scripts')
<script type="module" src="{{ asset('js/kds/app.js') }}"></script>
@endpush

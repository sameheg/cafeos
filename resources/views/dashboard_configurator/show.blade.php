@extends('layouts.app')
@section('title', $dashboard->name)

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">{{ $dashboard->name }}</h1>
</section>

<section class="content">
    <p><strong>Color:</strong> {{ $dashboard->color }}</p>
    <pre>{{ json_encode($dashboard->configuration, JSON_PRETTY_PRINT) }}</pre>
</section>
@endsection

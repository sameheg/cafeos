@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pricing Plans</h1>
    <div class="row">
        @foreach($plans as $plan)
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan->name }}</h5>
                        <p class="card-text">${{ $plan->price }} / {{ $plan->interval }}</p>
                        <form method="POST" action="{{ route('superadmin.subscribe') }}">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <button type="submit" class="btn btn-primary">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

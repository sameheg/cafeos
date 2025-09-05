@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Loyalty Points</h1>
    <p>Your balance: {{ $points }}</p>
    <form method="POST" action="{{ route('loyalty.redeem') }}">
        @csrf
        <div>
            <label for="points">Redeem Points</label>
            <input type="number" name="points" id="points" min="1" max="{{ $points }}">
        </div>
        <button type="submit">Redeem</button>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Redeem Coupon</h1>
    <form method="POST" action="{{ route('loyalty.coupons.redeem') }}">
        @csrf
        <div>
            <label for="code">Coupon Code</label>
            <input type="text" name="code" id="code" required>
        </div>
        <button type="submit">Redeem</button>
    </form>
</div>
@endsection

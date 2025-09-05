@extends('layouts.auth')

@section('title', __('Two Factor Authentication'))

@section('content')
<div class="container">
    <h3>{{ __('Two Factor Authentication') }}</h3>
    <p>{{ __('Use the following secret in your authenticator app:') }}</p>
    <p><strong>{{ $secret }}</strong></p>
    <p>{{ __('Recovery Codes:') }}</p>
    <ul>
        @foreach($recoveryCodes as $code)
            <li>{{ $code }}</li>
        @endforeach
    </ul>
    <form method="POST" action="{{ route('two-factor.disable') }}">
        @csrf
        <button type="submit" class="btn btn-danger">{{ __('Disable') }}</button>
    </form>
</div>
@endsection

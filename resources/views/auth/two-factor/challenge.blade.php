@extends('layouts.auth')

@section('title', __('Two Factor Challenge'))

@section('content')
<div class="container">
    <h3>{{ __('Please confirm access to your account') }}</h3>
    <form method="POST" action="{{ route('two-factor.verify') }}">
        @csrf
        <div class="form-group">
            <label for="code">{{ __('Authentication Code') }}</label>
            <input id="code" type="text" name="code" class="form-control" required autofocus>
            @error('code')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Verify') }}</button>
    </form>
</div>
@endsection

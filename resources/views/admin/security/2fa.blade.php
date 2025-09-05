@extends('layouts.app')

@section('content')
    <h1>{{ __('Two-Factor Authentication') }}</h1>

    @if(auth()->user()->two_factor_enabled)
        <p>{{ __('Two-factor authentication is enabled for your account.') }}</p>
        <form method="POST" action="{{ route('admin.security.2fa.disable') }}">
            @csrf
            <button type="submit">{{ __('Disable 2FA') }}</button>
        </form>
    @else
        <p>{{ __('Two-factor authentication is not enabled for your account.') }}</p>
        <form method="POST" action="{{ route('admin.security.2fa.enable') }}">
            @csrf
            <button type="submit">{{ __('Enable 2FA') }}</button>
        </form>
    @endif

    <hr>
    <h2>{{ __('Require 2FA for Roles') }}</h2>
    <form method="POST" action="{{ route('admin.security.2fa.roles') }}">
        @csrf
        @foreach($roles as $role)
            <div>
                <label>
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ in_array($role->id, $enforced) ? 'checked' : '' }}>
                    {{ $role->name }}
                </label>
            </div>
        @endforeach
        <button type="submit">{{ __('Save') }}</button>
    </form>
@endsection

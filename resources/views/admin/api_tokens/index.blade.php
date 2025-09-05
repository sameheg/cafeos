@extends('layouts.app')

@section('content')
    <h1>API Tokens</h1>
    <a href="{{ route('admin.api-tokens.create') }}">Create Token</a>
    <ul>
        @foreach($tokens as $token)
            <li>
                {{ $token->name }} - {{ $token->token }}
                @if($token->scopes)
                    ({{ implode(',', $token->scopes) }})
                @endif
                @if($token->expires_at)
                    expires {{ $token->expires_at->toDateString() }}
                @endif
                <a href="{{ route('admin.api-tokens.edit', $token) }}">Edit</a>
                <form method="POST" action="{{ route('admin.api-tokens.rotate', $token) }}" style="display:inline">
                    @csrf
                    <button type="submit">Rotate</button>
                </form>
                <form method="POST" action="{{ route('admin.api-tokens.destroy', $token) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection

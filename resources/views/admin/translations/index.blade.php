@extends('layouts.app')

@section('content')
    <h1>Translations</h1>

    <form method="GET" action="{{ route('admin.translations.index') }}">
        <select name="locale" onchange="this.form.submit()">
            @foreach($locales as $loc)
                <option value="{{ $loc }}" {{ $loc === $locale ? 'selected' : '' }}>{{ $loc }}</option>
            @endforeach
        </select>
        <input type="text" name="search" value="{{ $search }}" placeholder="Search">
        <button type="submit">Search</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Key</th>
                <th>Default</th>
                <th>Override</th>
            </tr>
        </thead>
        <tbody>
            @foreach($translations as $t)
                <tr>
                    <td>{{ $t['key'] }}</td>
                    <td>{{ $t['base'] }}</td>
                    <td>
                        <input type="text" value="{{ $t['override'] }}" data-key="{{ $t['key'] }}" class="translation-input">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.querySelectorAll('.translation-input').forEach(function (input) {
            input.addEventListener('change', function () {
                fetch('{{ route('admin.translations.update') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        locale: '{{ $locale }}',
                        key: input.dataset.key,
                        value: input.value
                    })
                });
            });
        });
    </script>
@endsection

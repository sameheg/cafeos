@extends('layouts.app')

@section('content')
    <h1>Equipment Status</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Temperature</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($devices as $device)
            <tr>
                <td>{{ $device->name }}</td>
                <td>{{ optional($device->readings->first())->temperature ?? 'N/A' }}</td>
                <td>{{ optional($device->readings->first())->status ?? 'N/A' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

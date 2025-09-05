@extends('layouts.app')

@section('content')
    <h1>Inventory Alerts</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Type</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alerts as $alert)
                <tr>
                    <td>{{ $alert->product->name ?? $alert->product_id }}</td>
                    <td>{{ $alert->type }}</td>
                    <td>{{ $alert->message }}</td>
                    <td>{{ $alert->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Queue Failed Jobs</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Connection</th>
                <th>Queue</th>
                <th>Failed At</th>
            </tr>
        </thead>
        <tbody>
        @foreach($failedJobs as $job)
            <tr>
                <td>{{ $job->id }}</td>
                <td>{{ $job->connection }}</td>
                <td>{{ $job->queue }}</td>
                <td>{{ $job->failed_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection

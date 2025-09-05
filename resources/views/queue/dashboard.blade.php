@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Queue Dashboard</h1>

    <h2>Active Queues</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Queue</th>
                <th>Pending Jobs</th>
            </tr>
        </thead>
        <tbody>
        @forelse($queues as $queue)
            <tr>
                <td>{{ $queue->queue }}</td>
                <td>{{ $queue->pending }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2">No active queues.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <h2>Pending Jobs</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Queue</th>
                <th>Attempts</th>
                <th>Available At</th>
            </tr>
        </thead>
        <tbody>
        @forelse($pendingJobs as $job)
            <tr>
                <td>{{ $job->id }}</td>
                <td>{{ $job->queue }}</td>
                <td>{{ $job->attempts }}</td>
                <td>{{ $job->available_at }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No pending jobs.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <h2>Failed Jobs</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Connection</th>
                <th>Queue</th>
                <th>Failed At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($failedJobs as $job)
            <tr>
                <td>{{ $job->id }}</td>
                <td>{{ $job->connection }}</td>
                <td>{{ $job->queue }}</td>
                <td>{{ $job->failed_at }}</td>
                <td>
                    <form action="{{ url('/queue/retry/' . $job->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">Retry</button>
                    </form>
                    <form action="{{ url('/queue/' . $job->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No failed jobs.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

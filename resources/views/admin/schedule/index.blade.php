@extends('layouts.app')

@section('content')
    <h1>Scheduled Tasks</h1>
    @if(session('status'))
        <div>{{ session('status') }}</div>
    @endif
    <table>
        <thead>
            <tr>
                <th>Command</th>
                <th>Frequency</th>
                <th>Enabled</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
            <tr>
                <td>{{ $task->command }}</td>
                <td>{{ $task->frequency }}</td>
                <td>{{ $task->enabled ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('admin.schedule.edit', $task) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.schedule.toggle', $task) }}" style="display:inline">
                        @csrf
                        <button type="submit">{{ $task->enabled ? 'Disable' : 'Enable' }}</button>
                    </form>
                    <form method="POST" action="{{ route('admin.schedule.run', $task) }}" style="display:inline">
                        @csrf
                        <button type="submit">Run</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection

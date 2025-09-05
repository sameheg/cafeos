@extends('layouts.app')

@section('content')
    <h1>Edit Task</h1>
    <form method="POST" action="{{ route('admin.schedule.update', $task) }}">
        @csrf
        @method('PUT')
        <div>
            <label>Command</label>
            <input type="text" name="command" value="{{ old('command', $task->command) }}">
        </div>
        <div>
            <label>Frequency (Cron)</label>
            <input type="text" name="frequency" value="{{ old('frequency', $task->frequency) }}">
        </div>
        <button type="submit">Save</button>
    </form>
@endsection

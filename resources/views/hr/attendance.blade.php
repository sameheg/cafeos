@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Attendance</h1>
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <form method="POST" action="{{ route('hr.attendance.store') }}">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">User ID</label>
            <input type="number" name="user_id" id="user_id" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" name="status" id="status" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="check_in" class="form-label">Check In</label>
            <input type="time" name="check_in" id="check_in" class="form-control">
        </div>
        <div class="mb-3">
            <label for="check_out" class="form-label">Check Out</label>
            <input type="time" name="check_out" id="check_out" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection

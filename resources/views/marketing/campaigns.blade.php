@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Marketing Campaigns</h1>
    <form method="POST" action="{{ route('campaigns.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input class="form-control" name="name">
        </div>
        <div class="mb-3">
            <label class="form-label">Channel</label>
            <select class="form-control" name="channel">
                <option value="sms">SMS</option>
                <option value="email">Email</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea class="form-control" name="content"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Schedule At</label>
            <input type="datetime-local" class="form-control" name="scheduled_at">
        </div>
        <button class="btn btn-primary" type="submit">Schedule</button>
    </form>
</div>
@endsection

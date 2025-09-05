@extends('layouts.app')
@section('title', 'Activity Log Settings')

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Activity Log Settings</h1>
</section>

<section class="content">
    {!! Form::open(['url' => action([App\Http\Controllers\ReportController::class, 'postActivityLogSettings']), 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('activity_log_retention_days', 'Retention Days') !!}
                {!! Form::number('activity_log_retention_days', $retention, ['class' => 'form-control', 'min' => 1]) !!}
            </div>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection


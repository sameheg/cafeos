@extends('layouts.app')
@section('title', 'Add Dashboard')

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Add Dashboard</h1>
</section>

<section class="content">
    {!! Form::open(['url' => action([\App\Http\Controllers\DashboardConfiguratorController::class, 'store'])]) !!}
    <div class="form-group">
        {!! Form::label('name', __('messages.name') . ':') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('color', 'Color:') !!}
        {!! Form::text('color', null, ['class' => 'form-control', 'required']) !!}
    </div>
    <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
    {!! Form::close() !!}
</section>
@endsection

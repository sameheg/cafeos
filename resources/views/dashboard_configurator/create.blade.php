@extends('layouts.app')
@section('title', __('Add Dashboard Configuration'))

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Add Dashboard Configuration</h1>
</section>

<section class="content">
    {!! Form::open(['url' => action([\App\Http\Controllers\DashboardConfiguratorController::class, 'store']), 'method' => 'post']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('name', __('messages.name') . ':') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('color', 'Color:') !!}
                    {!! Form::text('color', null, ['class' => 'form-control', 'required']) !!}
                </div>
            </div>
        </div>
        <input type="hidden" name="configuration" value="[]">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right">@lang('messages.save')</button>
            </div>
        </div>
    {!! Form::close() !!}
</section>
@endsection


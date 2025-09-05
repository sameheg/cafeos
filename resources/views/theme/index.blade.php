@extends('layouts.app')
@section('title', __('business.theme'))

@section('content')
<section class="content">
    {!! Form::open(['route' => 'themes.store', 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-4 form-group">
            {!! Form::label('name', __('messages.name')) !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4 form-group">
            {!! Form::label('primary_color', __('lang_v1.theme_color')) !!}
            {!! Form::select('primary_color', app(\App\Services\ThemeService::class)->getThemeColors(), null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4 form-group">
            {!! Form::label('secondary_color', __('lang_v1.secondary_color')) !!}
            {!! Form::text('secondary_color', null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4 form-group">
            {!! Form::label('logo', 'Logo') !!}
            {!! Form::text('logo', null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4 form-group">
            {!! Form::label('font', 'Font') !!}
            {!! Form::text('font', null, ['class' => 'form-control']) !!}
        </div>
        <div class="col-md-4 form-group">
            {!! Form::label('layout', __('lang_v1.layout')) !!}
            {!! Form::select('layout', ['light' => 'Light', 'dark' => 'Dark'], null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
    {!! Form::close() !!}

    <hr/>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>@lang('messages.name')</th>
                <th>@lang('lang_v1.theme_color')</th>
                <th>@lang('lang_v1.secondary_color')</th>
                <th>Logo</th>
                <th>Font</th>
                <th>@lang('messages.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($themes as $theme)
            <tr>
                <td>{{ $theme->name }}</td>
                <td>{{ $theme->primary_color }}</td>
                <td>{{ $theme->secondary_color }}</td>
                <td>{{ $theme->logo }}</td>
                <td>{{ $theme->font }}</td>
                <td class="d-flex">
                    {!! Form::open(['route' => ['themes.assign', $theme->id], 'method' => 'post', 'class' => 'mr-1']) !!}
                        <button type="submit" class="btn btn-sm btn-success">@lang('lang_v1.assign')</button>
                    {!! Form::close() !!}
                    {!! Form::open(['route' => ['themes.destroy', $theme->id], 'method' => 'delete']) !!}
                        <button type="submit" class="btn btn-sm btn-danger">@lang('messages.delete')</button>
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection

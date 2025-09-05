@extends('layouts.app')
@section('title', __('business.theme'))

@section('content')
<section class="content">
    {!! Form::open(['url' => url('api/themes'), 'method' => 'post', 'id' => 'theme_settings_form']) !!}
        <div class="form-group">
            {!! Form::label('primary_color', __('lang_v1.theme_color')) !!}
            {!! Form::select('primary_color', app(\App\Services\ThemeService::class)->getThemeColors(), null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('layout', __('lang_v1.layout')) !!}
            {!! Form::select('layout', ['light' => 'Light', 'dark' => 'Dark'], null, ['class' => 'form-control']) !!}
        </div>
        <theme-preview :primary="document.getElementById('primary_color').value" :layout="document.getElementById('layout').value"></theme-preview>
        <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
    {!! Form::close() !!}
</section>
@endsection


@extends('layouts.app')
@section('title', __('business.theme'))

@section('content')
<section class="content" id="theme-settings">
    {!! Form::open(['url' => url('api/themes'), 'method' => 'post', 'id' => 'theme_settings_form']) !!}
        <div class="form-group">
            {!! Form::label('primary_color', __('lang_v1.theme_color')) !!}
            {!! Form::select('primary_color', app(\App\Services\ThemeService::class)->getThemeColors(), null, ['class' => 'form-control', 'v-model' => 'primary']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('secondary_color', __('lang_v1.secondary_color')) !!}
            {!! Form::select('secondary_color', app(\App\Services\ThemeService::class)->getThemeColors(), null, ['class' => 'form-control', 'v-model' => 'secondary']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('layout', __('lang_v1.layout')) !!}
            {!! Form::select('layout', ['light' => 'Light', 'dark' => 'Dark'], null, ['class' => 'form-control', 'v-model' => 'layout']) !!}
        </div>
        <theme-preview :primary="primary" :secondary="secondary" :layout="layout"></theme-preview>
        <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
    {!! Form::close() !!}
</section>
<script>
    new Vue({
        el: '#theme-settings',
        data: {
            primary: '',
            secondary: '',
            layout: 'light'
        }
    });
</script>
@endsection

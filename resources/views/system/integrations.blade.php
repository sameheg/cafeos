@extends('layouts.app')
@section('title', __('System Integrations'))

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('System Integrations')</h1>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            {!! Form::open(['url' => route('system.integrations.update'), 'method' => 'post']) !!}
            <div class="row">
                @foreach($settings as $service => $items)
                    <div class="col-md-6">
                        <h3 class="text-capitalize">{{ $service }}</h3>
                        @foreach($items as $key => $value)
                            <div class="form-group">
                                {!! Form::label("settings[{$service}][{$key}]", $key) !!}
                                {!! Form::text("settings[{$service}][{$key}]", $value, ['class' => 'form-control']) !!}
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            {!! Form::close() !!}
        </div>
    </div>
</section>
@endsection

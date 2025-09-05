@extends('layouts.app')
@section('title', __('lang_v1.notification_templates'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">{{ __('lang_v1.notification_templates')}}</h1>
</section>

<!-- Main content -->
<section class="content">
    {!! Form::open(['url' => action([\App\Http\Controllers\NotificationTemplateController::class, 'store']), 'method' => 'post' ]) !!}

    <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.notifications') . ':'])
                @include('notification_template.partials.tabs', ['templates' => $general_notifications])
            @endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.customer_notifications') . ':'])
                @include('notification_template.partials.tabs', ['templates' => $customer_notifications])
            @endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-primary', 'title' => __('lang_v1.supplier_notifications') . ':'])
                @include('notification_template.partials.tabs', ['templates' => $supplier_notifications])

                <div class="callout callout-warning">
                    <p>@lang('lang_v1.logo_not_work_in_sms'):</p>
                </div>
            @endcomponent
        </div>
    </div>

    @php
        $all_templates = $general_notifications + $customer_notifications + $supplier_notifications;
        $template_options = [];
        foreach($all_templates as $key => $value) {
            $template_options[$key] = $value['name'];
        }
    @endphp

    <div class="row mt-10">
        <div class="col-md-4">
            {!! Form::select('test_template', $template_options, null, ['class' => 'form-control', 'id' => 'test_template']) !!}
        </div>
        <div class="col-md-4">
            <input type="email" id="test_email" class="form-control" placeholder="@lang('lang_v1.test_email')">
        </div>
        <div class="col-md-4">
            <input type="text" id="test_mobile" class="form-control" placeholder="@lang('lang_v1.test_mobile')">
        </div>
        <div class="col-md-12 text-center mt-10">
            <button type="button" id="send_test" class="tw-dw-btn tw-dw-btn-primary tw-dw-btn-lg tw-text-white">@lang('lang_v1.send_test')</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <button type="submit" class="tw-dw-btn tw-dw-btn-error tw-dw-btn-lg tw-text-white">@lang('messages.save')</button>
        </div>
    </div>
    {!! Form::close() !!}

</section>
<!-- /.content -->
@stop
@section('javascript')
<script type="text/javascript">
    $('textarea.ckeditor').each( function(){
        var editor_id = $(this).attr('id');
        tinymce.init({
            selector: 'textarea#'+editor_id,
        });
    });

    $('#send_test').on('click', function() {
        let template_for = $('#test_template').val();
        let email = $('#test_email').val();
        let mobile = $('#test_mobile').val();
        $.ajax({
            method: 'post',
            url: '{{action([\App\Http\Controllers\NotificationTemplateController::class, 'sendTest'])}}',
            data: {template_for: template_for, email: email, mobile: mobile},
            success: function(result) {
                if (result.whatsapp_link) {
                    window.open(result.whatsapp_link, '_blank');
                } else {
                    toastr.success("@lang('lang_v1.notification_sent_successfully')");
                }
            },
        });
    });
</script>
@endsection
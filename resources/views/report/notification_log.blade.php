@extends('layouts.app')
@section('title', __('lang_v1.notification_log'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">{{ __('lang_v1.notification_log') }}</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            @component('components.filters', ['title' => __('report.filters')])
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('nl_channel_filter', __('lang_v1.channel') . ':') !!}
                        {!! Form::select('nl_channel_filter', $channels, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('nl_date_filter', __('report.date_range') . ':') !!}
                        {!! Form::text('nl_date_filter', null, ['class' => 'form-control', 'readonly', 'placeholder' => __('lang_v1.select_a_date_range')]) !!}
                    </div>
                </div>
            @endcomponent
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @component('components.widget', ['class' => 'box-primary'])
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="notification_log_table">
                        <thead>
                            <tr>
                                <th>@lang('lang_v1.date')</th>
                                <th>@lang('contact.contact')</th>
                                <th>@lang('lang_v1.channel')</th>
                                <th>@lang('sale.status')</th>
                                <th>@lang('messages.message')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            @endcomponent
        </div>
    </div>
</section>
<!-- /.content -->
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#nl_date_filter').daterangepicker(dateRangeSettings, function(start, end){
            $('#nl_date_filter').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
            notification_log_table.ajax.reload();
        });
        $('#nl_date_filter').on('cancel.daterangepicker', function(ev, picker){
            $('#nl_date_filter').val('');
            notification_log_table.ajax.reload();
        });

        notification_log_table = $('#notification_log_table').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [[0, 'desc']],
            ajax: {
                url: '{{action([\App\Http\Controllers\ReportController::class, 'notificationLog'])}}',
                data: function(d){
                    if($('#nl_date_filter').val()){
                        d.start_date = $('input#nl_date_filter').data('daterangepicker').startDate.format('YYYY-MM-DD');
                        d.end_date = $('input#nl_date_filter').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    }
                    d.channel = $('#nl_channel_filter').val();
                }
            },
            columns: [
                {data: 'sent_at', name: 'sent_at'},
                {data: 'contact_name', name: 'contacts.name'},
                {data: 'channel', name: 'channel'},
                {data: 'status', name: 'status'},
                {data: 'message', name: 'message'}
            ]
        });

        $(document).on('change', '#nl_channel_filter', function(){
            notification_log_table.ajax.reload();
        });
    });
</script>
@endsection

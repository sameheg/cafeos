@extends('layouts.app')
@section('title', 'Dashboard Configurations')

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Dashboard Configurations</h1>
</section>

<section class="content">
    <a href="{{ action([\App\Http\Controllers\DashboardConfiguratorController::class, 'create']) }}" class="btn btn-primary">
        @lang('messages.add')
    </a>
    <table class="table table-bordered mt-15">
        <thead>
            <tr>
                <th>@lang('messages.name')</th>
                <th>Color</th>
                <th>@lang('messages.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dashboards as $dashboard)
                <tr>
                    <td>{{ $dashboard->name }}</td>
                    <td><span style="background-color: {{ $dashboard->color }}; padding: 5px 10px;">{{ $dashboard->color }}</span></td>
                    <td>
                        <a href="{{ action([\App\Http\Controllers\DashboardConfiguratorController::class, 'edit'], [$dashboard->id]) }}" class="btn btn-xs btn-primary">@lang('messages.edit')</a>
                        <button type="button" class="btn btn-xs btn-danger delete-dashboard" data-href="{{ action([\App\Http\Controllers\DashboardConfiguratorController::class, 'destroy'], [$dashboard->id]) }}">@lang('messages.delete')</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! Form::open(['url' => '', 'method' => 'DELETE', 'id' => 'delete_dashboard_form']) !!}
    {!! Form::close() !!}
</section>
@endsection

@section('javascript')
<script>
$(document).on('click', '.delete-dashboard', function(e){
    e.preventDefault();
    if(confirm(LANG.sure)){
        $('#delete_dashboard_form').attr('action', $(this).data('href')).submit();
    }
});
</script>
@endsection

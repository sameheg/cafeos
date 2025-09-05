@extends('layouts.app')
@section('title', __('Dashboard Configurations'))

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Dashboard Configurations</h1>
</section>

<section class="content">
    <a href="{{ action([\App\Http\Controllers\DashboardConfiguratorController::class, 'create']) }}" class="btn btn-primary mb-3">
        @lang('messages.add')
    </a>
    <table class="table">
        <thead>
            <tr>
                <th>@lang('messages.name')</th>
                <th>Color</th>
                <th>@lang('messages.action')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dashboards as $dashboard)
                <tr>
                    <td>{{ $dashboard->name }}</td>
                    <td>{{ $dashboard->color }}</td>
                    <td>
                        <a href="{{ action([\App\Http\Controllers\DashboardConfiguratorController::class, 'edit'], [$dashboard->id]) }}" class="btn btn-xs btn-primary">@lang('messages.edit')</a>
                        {!! Form::open(['url' => action([\App\Http\Controllers\DashboardConfiguratorController::class, 'destroy'], [$dashboard->id]), 'method' => 'delete', 'style' => 'display:inline-block']) !!}
                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm(LANG.sure);">@lang('messages.delete')</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">{{ __('No configurations found') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</section>
@endsection


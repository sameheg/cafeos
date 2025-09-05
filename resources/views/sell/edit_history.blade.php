@extends('layouts.app')

@section('title', __('lang_v1.sale_edit_history'))

@section('content')
<section class="content-header">
    <h1>@lang('lang_v1.sale_edit_history')</h1>
</section>

<section class="content">
    <div class="box box-solid">
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>@lang('lang_v1.edited_at')</th>
                        <th>@lang('role.user')</th>
                        <th>@lang('lang_v1.changes')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->edited_at }}</td>
                            <td>{{ $log->user->user_full_name ?? '' }}</td>
                            <td><pre>{{ json_encode($log->changes, JSON_PRETTY_PRINT) }}</pre></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">@lang('lang_v1.no_records_found')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

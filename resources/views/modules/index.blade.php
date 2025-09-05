@extends('layouts.app')
@section('title', __('Module Statuses'))

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">
        @lang('Module Statuses')
    </h1>
</section>
<section class="content">
    @component('components.widget')
        <table class="table">
            <tr>
                <th>@lang('Module')</th>
                <th>@lang('Status')</th>
                <th>@lang('Action')</th>
            </tr>
            @foreach($modules as $name => $enabled)
                <tr>
                    <td>{{ $name }}</td>
                    <td>
                        @if($enabled)
                            <span class="label label-success">@lang('Enabled')</span>
                        @else
                            <span class="label label-danger">@lang('Disabled')</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('modules.toggle', $name) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">
                                @lang('Toggle')
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @endcomponent
</section>
@endsection

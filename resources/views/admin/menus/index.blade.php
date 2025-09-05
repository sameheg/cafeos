@extends('layouts.app')
@section('title', __('Menu'))

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('Menu')</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
                @lang('messages.add')
            </a>
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>@lang('Label')</th>
                        <th>@lang('URL')</th>
                        <th>@lang('Icon')</th>
                        <th>@lang('Permission')</th>
                        <th>@lang('Order')</th>
                        <th>@lang('messages.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $menu)
                    <tr>
                        <td>{{ $menu->label }}</td>
                        <td>{{ $menu->url }}</td>
                        <td>{{ $menu->icon }}</td>
                        <td>{{ $menu->permission }}</td>
                        <td>{{ $menu->order }}</td>
                        <td>
                            <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-xs btn-primary">@lang('messages.edit')</a>
                            <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-danger">@lang('messages.delete')</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@section('content')
    <h1>Menus</h1>
    <a href="{{ route('admin.menus.create') }}">Create Menu</a>
    <ul>
        @foreach($menus as $menu)
            <li>
                {{ $menu->label }} - {{ $menu->url }}
                <a href="{{ route('admin.menus.edit', $menu) }}">Edit</a>
                <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection

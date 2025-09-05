@extends('layouts.app')
@section('title', __('Create Menu'))

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">@lang('Create Menu')</h1>
</section>

<section class="content">
    <form action="{{ route('admin.menus.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="label">@lang('Label')</label>
            <input type="text" name="label" id="label" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="url">@lang('URL')</label>
            <input type="text" name="url" id="url" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="icon">@lang('Icon')</label>
            <input type="text" name="icon" id="icon" class="form-control">
        </div>
        <div class="form-group">
            <label for="permission">@lang('Permission')</label>
            <input type="text" name="permission" id="permission" class="form-control">
        </div>
        <div class="form-group">
            <label for="order">@lang('Order')</label>
            <input type="number" name="order" id="order" class="form-control" value="0" required>
        </div>
        <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
    </form>
</section>
@endsection

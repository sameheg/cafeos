@extends('layouts.app')
@section('title', __('Hardware Settings'))

@section('content')
<section class="content-header">
    <h1 class="tw-text-xl md:tw-text-3xl tw-font-bold tw-text-black">Hardware Settings</h1>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <form method="POST" action="{{ route('settings.hardware.save') }}">
                @csrf
                <div class="form-group">
                    <label for="printer_port">Printer Port</label>
                    <input type="text" id="printer_port" name="devices[printer][port]" class="form-control" value="{{ config('hardware.devices.printer.port') }}">
                </div>
                <div class="form-group">
                    <label for="printer_driver">Printer Driver</label>
                    <input type="text" id="printer_driver" name="devices[printer][driver]" class="form-control" value="{{ config('hardware.devices.printer.driver') }}">
                </div>
                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            </form>
        </div>
    </div>
</section>
@endsection

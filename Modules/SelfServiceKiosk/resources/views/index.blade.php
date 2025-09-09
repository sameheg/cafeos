@extends('pos::layouts.master')

@section('content')
<div id="kiosk-app" data-translations='@json([
    "drive_thru" => __("self-service-kiosk::kiosk.drive_thru"),
    "takeaway" => __("self-service-kiosk::kiosk.takeaway"),
    "start_order" => __("self-service-kiosk::kiosk.start_order"),
    "hardware_instructions" => __("self-service-kiosk::kiosk.hardware_instructions"),
    "queue_number" => __("self-service-kiosk::kiosk.queue_number"),
])'></div>
@endsection

@vite('Modules/SelfServiceKiosk/resources/js/kiosk.js')

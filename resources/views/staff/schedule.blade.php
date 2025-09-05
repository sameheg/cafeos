@extends('layouts.app')

@section('content')
<div class="container">
    <div id="calendar"></div>
</div>
@endsection

@section('javascript')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" integrity="sha512-Rd0uN2ZK5gkAun1vDLteA94ppIqhzyapMI2vlA38nSxrdbidK4USsfx8bVsgcF6edS5E2xe50Tzw9c7mGXk4sA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894ye88GZB1K1Y1Bo3F0Xo0XcqCX3ZX3v1C1Ik5+pG+1hb8EhL1E6r5K3vnDnN/SfX2RK7aGxU5n0b4K6Bbl7w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8FsFNqL0J3B8BzNPSeN5e7C1z9Yx5e1koXSPoaqe7i0rGUNShUMpOW1n38qRAjPR9UCeFZkvYwA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js" integrity="sha512-vsI3HBpjz2uVH54camzato3trENcGukdxbYlR5c+3F4iAfDdc0AGJi/7luWGINuD/7++UZ5EKeosFVJeFt3I8Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(function() {
    $('#calendar').fullCalendar({
        selectable: true,
        editable: true,
        events: @json($shifts->map(function ($shift) {
            return [
                'id' => $shift->id,
                'title' => 'Shift',
                'start' => $shift->start_time,
                'end' => $shift->end_time,
            ];
        })),
        select: function(start, end) {
            $.post('{{ route('staff.schedule.store') }}', {
                employee_id: {{ auth()->id() }},
                start_time: start.format(),
                end_time: end.format(),
                _token: '{{ csrf_token() }}'
            }).done(function() {
                location.reload();
            });
        },
        eventDrop: updateEvent,
        eventResize: updateEvent,
    });

    function updateEvent(event) {
        $.ajax({
            url: '{{ url('staff/schedule') }}/' + event.id,
            type: 'PUT',
            data: {
                start_time: event.start.format(),
                end_time: event.end.format(),
                _token: '{{ csrf_token() }}'
            }
        });
    }
});
</script>
@endsection

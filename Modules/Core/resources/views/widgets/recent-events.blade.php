<div>
    <ul>
        @foreach ($events as $event)
            <li>{{ $event->event_name }}</li>
        @endforeach
    </ul>
</div>

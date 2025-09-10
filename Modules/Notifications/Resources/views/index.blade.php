<h1>Notifications Inbox</h1>
<table>
    <thead>
        <tr>
            <th>Message</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notifications as $notification)
            <tr>
                <td>{{ $notification->message }}</td>
                <td>{{ $notification->role }}</td>
                <td>{{ $notification->status }}</td>
                <td>
                    <form method="POST" action="/notifications/{{ $notification->id }}/acknowledge" style="display:inline">
                        @csrf
                        <button type="submit">Acknowledge</button>
                    </form>
                    <form method="POST" action="/notifications/{{ $notification->id }}/escalate" style="display:inline">
                        @csrf
                        <button type="submit">Escalate</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

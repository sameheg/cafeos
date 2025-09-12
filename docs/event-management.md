# Event Management Module

This module handles events, tickets and waitlists.

```mermaid
stateDiagram-v2
    [*] --> Booked
    Booked --> Sold: sell()
    Sold --> Attended: checkin()
    Sold --> Refunded: cancel()
```

## API

- `POST /api/v1/events/tickets` – purchase a ticket.
- `GET /api/v1/events/{id}/waitlist` – view waitlist.

```php
$response = Http::post('/api/v1/events/tickets', ['event_id' => $eventId]);
```

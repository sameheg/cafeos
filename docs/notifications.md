# Notifications Module

Handles templated, rate-limited notifications with channel fallbacks and chunked delivery.

## State Machine
```mermaid
stateDiagram-v2
    [*] --> Queued
    Queued --> Sent: send()
    Sent --> Delivered: confirm()
    Sent --> Failed: fail()
    Failed --> Retried: retry()
```

## API
- `POST /api/v1/notifications` send notifications
- `PATCH /api/v1/notifications/preferences` update preferences

## Example
```php
$notifId = app(\Modules\Notifications\Services\NotificationSender::class)
    ->send($template, ['user@example.com']);
```

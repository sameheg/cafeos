# KDS Agent

## Events
- `kds.ticket.created` — emitted when a new order reaches the kitchen.
- `kds.ticket.update` — sent when the kitchen modifies an existing ticket.

### `kds.ticket.update` Payload
```json
{
  "event": "kds.ticket.update",
  "ticket": {
    "id": 123,
    "status": "modified",
    "note": "No onions"
  }
}
```
Connected listeners (e.g. POS) should apply the change or notify staff.

# POS Agent

## Events
- Listens for `kds.ticket.update` from the KDS Agent.

### Update Payload
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
Upon receiving the event, the POS should adjust the order or alert the cashier.

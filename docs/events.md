# Domain Events

Services communicate through JSON domain events. Event names follow the pattern
`context.action@v1` and payloads are camelCase.

## admin.module.toggled@v1

```json
{
  "module": "Inventory",
  "tenantId": "uuid",
  "enabled": true
}
```

## billing.invoice.paid@v1

```json
{
  "invoiceId": "...",
  "tenantId": "...",
  "amount": 1234
}
```

All events are published to the message broker and stored for audit logging.


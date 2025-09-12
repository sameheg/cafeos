# Food Safety Module

Tracks temperature logs, HACCP actions and alerts.

## State Machine
```mermaid
stateDiagram-v2
    [*] --> Monitored
    Monitored --> Alerted: threshold_breach()
    Alerted --> Corrected: action()
    Corrected --> Compliant: verify()
```

## API
- `POST /v1/foodsafety/logs`
- `GET /v1/foodsafety/incidents`

## Event Example
```json
{"event":"foodsafety.breach.detected","data":{"item_id":"1313","temp":10}}
```

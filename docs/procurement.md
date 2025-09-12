# Procurement Module

This module manages RFQs, bids, purchase orders (PO) and goods received notes (GRN). It exposes a REST API and emits domain events.

## State Machine

```mermaid
stateDiagram-v2
    [*] --> Draft
    Draft --> Sent: send()
    Sent --> Received: receive()
    Received --> Matched: match()
    Sent --> Cancelled: cancel()
    Received --> Varied: variance_detect()
```

## Example Event Payload

```json
{"event":"procurement.po.created","data":{"po_id":"101","supplier_id":"sup1"}}
```

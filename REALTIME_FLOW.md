# Realtime Data Flow

## Overview
- TBD

## Prerequisites
- TBD

## Setup
- TBD

## Usage
- TBD

## References
- TBD


## Overview
This diagram illustrates the realtime interactions between modules during daily operations.  
Data flows through POS, Inventory, KDS, Billing, Reports, and CRM using WebSockets, Events, and Queues.

---

## Realtime Data Flow Diagram
```mermaid
flowchart TD
    Customer -->|Places Order| POS
    POS -->|Sends Order| KDS
    KDS -->|Order Status| POS
    POS -->|Deduct Stock| Inventory
    Inventory -->|Low Stock Alert| Manager
    POS -->|Generates Payment| Billing
    Billing -->|Invoice Issued| Reports
    POS -->|Sales Data| Reports
    Inventory -->|Stock Data| Reports
    CRM -->|Customer Loyalty| Reports
    POS -->|Customer Data| CRM
```

---

## Key Notes
- **POS ↔ KDS**: Orders synced in realtime with WebSockets.  
- **POS ↔ Inventory**: Stock deducted instantly per order item.  
- **POS ↔ Billing**: Invoices generated per transaction.  
- **Reports** aggregates all data streams: Sales, Inventory, Billing, CRM.  
- **CRM** updates loyalty points and customer segmentation in realtime.  

---

## Technology
- **WebSockets (Pusher/Socket.IO)** → POS/KDS sync.  
- **Redis Pub/Sub** → Inventory and Billing events.  
- **Queue Workers (Horizon)** → async processing.  

# Food Expiry Tracking

## Overview
Tracks expiry dates for perishable items.

## Features
- Batch-based expiry
- Alerts before expiry
- Auto-removal from availability

## Flow
```mermaid
flowchart TD
    Inventory --> ExpiryTracker
    ExpiryTracker --> Alerts
    ExpiryTracker --> Reports
```

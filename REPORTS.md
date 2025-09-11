# Reports Module

## Overview
Aggregates data from POS, Inventory, Billing, CRM.

## Features
- Sales reports
- Inventory usage reports
- Customer activity reports
- Financial statements

## Exports
- PDF, Excel, CSV

## Flow
```mermaid
flowchart TD
    POS --> Reports
    Inventory --> Reports
    Billing --> Reports
    CRM --> Reports
```

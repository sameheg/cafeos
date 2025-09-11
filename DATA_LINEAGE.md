# Data Lineage

## Overview
Tracks data flow from source to destination.

## Flow
```mermaid
flowchart TD
    POS --> ETL
    Inventory --> ETL
    CRM --> ETL
    ETL --> Warehouse[Data Warehouse]
    Warehouse --> BI[BI Dashboards]
```

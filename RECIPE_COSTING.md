# Recipe Costing & BOM

## Overview
Defines cost calculation for recipes and menu items.

## Features
- Bill of Materials (BOM)
- Auto-deduct ingredients from inventory
- Calculate cost per serving
- Profit margin analysis

## Flow
```mermaid
flowchart TD
    Recipe --> BOM[Bill of Materials]
    BOM --> Inventory
    Inventory --> Costing
    Costing --> POSPrice
```

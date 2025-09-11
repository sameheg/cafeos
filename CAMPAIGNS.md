# Campaigns (CRM & Loyalty)

## Overview
Campaign engine for marketing & promotions.

## Features
- Seasonal discounts
- Loyalty multipliers (double points week)
- Targeted offers (customer segments)

## Flow
```mermaid
flowchart TD
    TenantAdmin --> Campaigns
    Campaigns --> Customers
    Campaigns --> CRM
    CRM --> Reports
```

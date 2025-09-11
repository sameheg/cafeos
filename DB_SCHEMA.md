# Database Schema (High-Level ERD)

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


## Diagram
```mermaid
erDiagram
    TENANTS ||--o{ USERS : has
    TENANTS ||--o{ ORDERS : owns
    USERS ||--o{ ORDERS : creates
    ORDERS ||--o{ ORDER_ITEMS : contains
    ORDERS ||--o{ PAYMENTS : paid_by
    INVENTORY_ITEMS ||--o{ STOCK_MOVEMENTS : tracks
    CUSTOMERS ||--o{ LOYALTY : earns
    SUBSCRIPTIONS ||--o{ INVOICES : generates
    VENDORS ||--o{ PLUGINS : offers
    JOB_POSTS ||--o{ APPLICATIONS : receives
    LISTINGS {
        int id
        string type
        string location
        decimal price
        string status
    }
```

## Tenancy
- tenants (id, name, domain, db/schema reference)
- users (id, tenant_id, role_id, email, password)

## POS
- orders (id, tenant_id, customer_id, total, status)
- order_items (id, order_id, sku, qty, price)
- payments (id, order_id, method, status)

## Inventory
- items (id, tenant_id, sku, name, qty, expiry_date)
- stock_movements (id, item_id, change, reason)

## Billing
- subscriptions (id, tenant_id, plan, status)
- invoices (id, subscription_id, amount, status)

## CRM
- customers (id, tenant_id, name, email, preferences)
- loyalty (id, customer_id, points)

## Marketplace
- vendors (id, name, rating)
- plugins (id, vendor_id, module, status)

## Jobs
- job_posts (id, tenant_id, title, description)
- applications (id, job_post_id, applicant_name, status)

## Rentals
- listings (id, type, location, price, status)

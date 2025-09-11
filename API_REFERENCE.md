# API Reference

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


This document describes core API endpoints.  
For a full specification, see `openapi.yaml` or Postman collection.

## Auth
- `POST /api/auth/login`
- `POST /api/auth/register`
- `POST /api/auth/logout`

## POS
- `POST /api/pos/orders` → Create new order.  
- `GET /api/pos/orders/{id}` → Get order details.  

## Inventory
- `GET /api/inventory/items` → List items.  
- `POST /api/inventory/adjust` → Adjust stock.  

## Billing
- `POST /api/billing/subscribe` → Subscribe tenant to plan.  
- `GET /api/billing/invoices` → List invoices.  

## Marketplace
- `GET /api/marketplace/vendors` → List vendors.  
- `POST /api/marketplace/plugins/install` → Install plugin.  

## Error Codes
- **400** Bad Request → Invalid input.  
- **401** Unauthorized → Missing/invalid token.  
- **403** Forbidden → No permission.  
- **404** Not Found → Resource missing.  
- **500** Internal Server Error → Unexpected issue.  

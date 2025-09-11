# API Reference

## Overview
- This section outlines the primary goals and scope of Api Reference.

## Prerequisites
- Familiarity with basic Api Reference concepts and system requirements is recommended.

## Setup
- Follow these steps to configure and enable Api Reference in your environment.

## Usage
- Instructions and examples for applying Api Reference in day-to-day operations.

## References
- Additional resources and documentation about Api Reference for further learning.


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

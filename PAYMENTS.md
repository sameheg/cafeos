# Payments

## Overview
Handles all payment processing.

## Supported
- Stripe
- Paddle
- Offline bank transfers

## Features
- PCI DSS compliance
- Retry logic for failed payments
- Webhooks for payment events

## Flow
```mermaid
flowchart TD
    Tenant --> Checkout
    Checkout --> Stripe
    Stripe --> Billing
    Billing --> Reports
```

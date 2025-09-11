# Tenant Journey

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


## Step 1: Signup
- Tenant signs up with email, company name, domain.
- System generates tenant schema/database.
- Assigns default roles (Owner, Manager).

## Step 2: Plan Selection & Payment
- Tenant chooses subscription plan.
- Redirect to Stripe/Paddle for payment.
- Upon confirmation → activate modules for tenant.

## Step 3: Initial Setup
- Configure branding (logo, colors).
- Import menu/inventory templates.
- Seed default roles and permissions.
- Connect hardware (printers, KDS, scanners).

## Step 4: Staff Onboarding
- Tenant invites staff by email.
- Assign roles (cashier, waiter, chef, manager).
- Staff receive credentials + onboarding guide.

## Step 5: Module Enablement
- Tenant Admin enables/disables modules (CRM, Reservations, Marketplace).
- Modules load dynamically via feature flags.

## Step 6: Daily Operations
- POS handles orders.
- Inventory deducts stock automatically.
- CRM tracks customers & loyalty.
- Reservations sync with POS.

## Step 7: Billing & Reports
- Subscriptions auto-renew monthly.
- Billing generates invoices and sends reminders.
- Reports module aggregates tenant KPIs.

## Step 8: Support & Scaling
- In-app support chat + knowledge base.
- Option to upgrade plan for more features.
- Scaling with load balancer & HA infra.

---

## Tenant Journey Flow
```mermaid
flowchart TD
    A[Signup] --> B[Plan Selection & Payment]
    B --> C[Initial Setup]
    C --> D[Staff Onboarding]
    D --> E[Module Enablement]
    E --> F[Daily Operations]
    F --> G[Billing & Reports]
    G --> H[Support & Scaling]
```

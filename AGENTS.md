# Modules (Agents) Documentation

## Core & Governance
### Core
- Multi-tenancy, RBAC, EventBus.  

### Super Admin
- Manage tenants, billing, branding.  

### Billing
- Stripe/Paddle integration.  

```mermaid
flowchart LR
    Tenant -->|Subscribe| Billing
    Billing -->|Invoice| Tenant
    Billing -->|Reports| SuperAdmin
```

## Hospitality Ops
### POS
- Orders, payments, receipts.  

```mermaid
flowchart LR
    Customer --> POS
    POS --> Inventory
    POS --> Billing
    POS --> Reports
```

### Inventory
- Stock levels, expiry, auditing.  

```mermaid
flowchart LR
    Procurement --> Inventory
    Inventory --> POS
    Inventory --> Reports
```

### KDS
- Kitchen display system.  

```mermaid
flowchart LR
    POS --> KDS
    KDS --> Chef
    Chef --> POS
```

### Procurement
- Supplier management, stock transfers.  

```mermaid
flowchart LR
    Supplier --> Procurement
    Procurement --> Inventory
    Procurement --> Reports
```

### CRM
- Customers, loyalty, coupons.  

```mermaid
flowchart LR
    Customer --> CRM
    CRM --> POS
    CRM --> Loyalty
    Loyalty --> Reports
```

### Reservations
- Table booking system.  

```mermaid
flowchart LR
    Customer --> Reservations
    Reservations --> POS
```

### Franchise
- Manage multi-branch operations.  

### Food Safety
- HACCP, compliance logs.  

## Extensions
### Marketplace
- Vendors, integrations, plugin system.  

```mermaid
flowchart LR
    Vendor --> Marketplace
    Marketplace --> Tenant
    Marketplace --> Billing
```

### Jobs
- Recruitment, employee applications.  

```mermaid
flowchart LR
    Candidate --> Jobs
    Jobs --> HR
    HR --> Tenant
```

### Rentals
- Restaurant/cafe rentals or sales.  

```mermaid
flowchart LR
    Owner --> Rentals
    Rentals --> Tenant
    Rentals --> Billing
```

### Training
- Staff training and evaluation.  

### Energy Tracking
- Monitor electricity/water usage.  

### Equipment
- Maintenance tracking.  

### AR/VR Menu
- Immersive menu experience.  

```mermaid
flowchart LR
    Customer --> ARVRMenu
    ARVRMenu --> POS
```


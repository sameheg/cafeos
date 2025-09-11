# User Roles & Permissions

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


## Overview
Defines the access control matrix for different user roles in the system.  
Roles are enforced with RBAC at both tenant and module level.

---

## Roles
- **Owner** → Full access across all modules, billing, and settings.  
- **Manager** → Full access to operations (POS, Inventory, CRM), limited access to billing/settings.  
- **Cashier** → POS operations and limited CRM access.  
- **Waiter** → Create/view orders, basic CRM view.  
- **Chef** → View and update order status in KDS.  

---

## Permissions Matrix
| Role    | POS        | Inventory | CRM       | Reservations | Billing | Marketplace | Admin Settings |
|---------|------------|-----------|-----------|--------------|---------|-------------|----------------|
| Owner   | Full       | Full      | Full      | Full         | Full    | Full        | Full           |
| Manager | Full       | Full      | Full      | Full         | Limited | Limited     | Limited        |
| Cashier | Orders     | View      | Limited   | View         | None    | None        | None           |
| Waiter  | Orders     | None      | View      | View         | None    | None        | None           |
| Chef    | View Orders| None      | None      | None         | None    | None        | None           |

---

## Role Flow
```mermaid
flowchart TD
    Owner -->|Delegates| Manager
    Manager -->|Assigns Tasks| Cashier
    Manager -->|Assigns Tasks| Waiter
    Manager -->|Assigns Tasks| Chef

    Cashier --> POS
    Waiter --> POS
    Chef --> KDS
    Manager --> Inventory
    Manager --> CRM
    Owner --> Billing
    Owner --> Marketplace
    Owner --> Settings
```

---

## Security Notes
- 2FA required for Owner & Manager.  
- Session timeout: 30 min idle.  
- All actions logged in audit trail.  

# 📘 MODULES_OVERVIEW.md

## 🏛️ Core & Governance Modules
### 1. **Core (Multi-Tenancy & User Management)**
- **Purpose**: Central brain of the platform.  
- **Features**: Multi-Tenancy, User & Role Management, Event Bus.  
- **Frontend**: Tenant switcher, Login.  
- **Admin Panel**: Manage tenants, users, roles.  
- **Database**: `tenants`, `users`, `roles`, `permissions`.  
- **Roles**: Super Admin, Tenant Admin.  
- **Integrations**: Required by all modules.  
- **Isolation**: Must be always-on, others depend on it.  

### 2. **Super Admin**
- Manage entire SaaS (subscriptions, branding, module activation).  
- Enable/disable modules per tenant.  
- Database: `subscriptions`, `plans`.  
- Only accessible by SaaS-level staff.  

---

## 🍽️ Restaurant & Cafe Operations
### 3. **POS (Point of Sale)**
- **Features**:  
  - Open multiple tables per waiter.  
  - Move orders between tables.  
  - Split bills.  
  - Unpaid orders → mark as debt.  
- **Frontend**: Waiter tablet UI (drag/drop tables, fast actions).  
- **Admin**: POS settings, price rules.  
- **Database**: `orders`, `order_items`, `tables`.  
- **Roles**: Waiter, Cashier, Manager.  
- **Integrations**: Inventory, CRM, Reports.  
- **Isolation**: POS should run offline with sync.  

### 4. **KDS (Kitchen Display System)**
- **Features**: Kitchen receives **approved orders only**.  
- **Frontend**: Chef screen with color-coded statuses (pending, cooking, ready).  
- **Admin**: Configure stations (Grill, Drinks).  
- **Database**: `kitchen_tickets`.  
- **Roles**: Chef, Kitchen Manager.  
- **Integration**: POS.  

### 5. **Floor Plan Designer**
- **Features**: Manager draws restaurant (drag & drop tables/chairs).  
- **Frontend**: Visual editor, RTL support.  
- **Database**: `floor_layouts`.  
- **Integration**: POS.  

---

## 📦 Inventory & Supply
### 6. **Inventory**
- **Features**: Stock tracking, FIFO/LIFO, alerts (low stock).  
- **Database**: `inventory_items`, `stock_movements`.  
- **Integration**: POS (deduct), Procurement.  

### 7. **Procurement / Suppliers**
- **Features**: Purchase orders, supplier directory.  
- **Database**: `suppliers`, `purchase_orders`.  
- **Integration**: Inventory.  

### 8. **Marketplace**
- **Features**: Vendors list equipment/ingredients; managers can buy directly into stock.  
- **Database**: `marketplace_products`, `marketplace_orders`.  
- **Integration**: Procurement, Inventory.  

---

## 💳 Billing & Membership
### 9. **Billing & Subscriptions**
- **Features**: Stripe/Paddle integration, tenant plans.  
- **Database**: `subscriptions`.  
- **Integration**: Super Admin.  

### 10. **Membership System**
- **Purpose**: Unified accounts for SaaS ecosystem.  
- **Roles**:  
  - SaaS Admin staff.  
  - Restaurant/café owners.  
  - Employees (waiters, chefs, cashiers).  
  - Suppliers (equipment, ingredients).  
  - Job Seekers.  
  - Marketplace advertisers (restaurants/cafés for rent/sale).  
- **Database**: `memberships`, `member_profiles`.  

---

## 👥 Customers & Loyalty
### 11. **CRM**
- **Features**: Customer profiles, order history.  
- **Database**: `customers`.  
- **Integration**: POS, Loyalty.  

### 12. **Loyalty & Coupons**
- **Features**: Points system, coupons, vouchers.  
- **Database**: `loyalty_points`, `coupons`.  
- **Integration**: CRM, POS.  

### 13. **QR Ordering**
- **Flow**:  
  - Customer scans QR → places order.  
  - Order goes to waiter for approval.  
  - Waiter approves → ticket sent to KDS.  
- **Frontend**: Customer-facing menu (multi-lang, RTL).  
- **Integration**: POS, KDS.  

---

## 📊 Reports & Monitoring
### 14. **Reports**
- **Filters**: By day, shift, hour, employee, item, customer.  
- **Exports**: CSV, Excel, PDF.  
- **Integration**: All transaction modules.  

### 15. **Notifications**
- **Scope**: Manager, Waiter, Kitchen, Super Admin, SaaS staff.  
- **Channels**: In-app, Email, SMS, Push.  
- **Events**: Low stock, unpaid bill, table opened, subscription expiring.  
- **Integration**: Global across modules.  

---

## 🧩 Extra Modules
### 16. **HR & Jobs**
- **Features**: Post jobs, apply, track candidates.  
- **Database**: `jobs`, `applications`.  
- **Integration**: Membership system.  

### 17. **Restaurant Rentals**
- **Features**: Post restaurants/cafés for rent/sale.  
- **Database**: `listings`.  
- **Integration**: Membership system.  

### 18. **Equipment Maintenance**
- **Features**: Track kitchen/coffee equipment health, schedule maintenance.  
- **Database**: `equipment`, `maintenance_logs`.  

---

# 🌍 Multi-Language & RTL
- Every module must support **i18n (EN + AR)**.  
- RTL must be tested in POS, Reports, Floor Plan Designer.  
- Translations stored in `lang/{locale}.json`.  

---

# ✅ Developer Rules (Applies to All Modules)
1. **Isolation**: Each module = standalone (own DB, UI, Admin, API).  
2. **Integration**: Communication only via Events/Services.  
3. **Permissions**: Define roles & permissions per module.  
4. **DB**: `tenant_id` mandatory in every table.  
5. **UI**: Vue 3 + Inertia + Tailwind + vue-i18n.  
6. **Admin**: Filament v4 resources.  
7. **Languages**: EN + AR (RTL support required).  
8. **Testing**: Feature + Unit + UI tests (80% coverage).  

---

🔥 **Golden Rule**:  
> “Each module is an independent country inside the union.  
> It must work alone, and seamlessly with the rest.”



# 🛠️ Development Roadmap

## Phase 1 — Foundation
1. **Core Module** → Multi-Tenancy, User & Role Management, Event Bus.  
2. **Super Admin Module** → SaaS control panel, subscription management, module toggling.  
3. **Membership System** → Accounts for all roles (owners, staff, suppliers, seekers).  

✅ Output: SaaS platform skeleton ready, multi-tenant structure in place.  

---

## Phase 2 — Restaurant Core
4. **POS Module** → Tables, Orders, Bills, Debts.  
5. **KDS Module** → Kitchen order workflow.  
6. **Floor Plan Designer** → Drag & drop restaurant layout.  

✅ Output: Basic restaurant/café operations fully digital.  

---

## Phase 3 — Supply Chain & Inventory
7. **Inventory Module** → Stock tracking, alerts.  
8. **Procurement / Suppliers Module** → Purchase orders & suppliers.  
9. **Marketplace Module** → Vendor marketplace (equipment, food supply).  

✅ Output: End-to-end supply + procurement cycle.  

---

## Phase 4 — Customers & Engagement
10. **CRM Module** → Customer profiles & orders history.  
11. **Loyalty & Coupons Module** → Points, discounts, vouchers.  
12. **QR Ordering Module** → Customer scans → order → waiter approval → KDS.  

✅ Output: Enhanced customer experience & loyalty tools.  

---

## Phase 5 — Reporting & Monitoring
13. **Reports Module** → By day, shift, hour, employee, item, customer.  
14. **Notifications Module** → Alerts for managers, waiters, chefs, super admins.  

✅ Output: Full visibility & real-time monitoring.  

---

## Phase 6 — Advanced SaaS Features
15. **Billing & Subscriptions Module** → Stripe/Paddle, tenant plans.  
16. **HR & Jobs Module** → Hiring system inside SaaS.  
17. **Restaurant Rentals Module** → Marketplace for renting/selling cafés & restaurants.  
18. **Equipment Maintenance Module** → Equipment lifecycle & maintenance logs.  

✅ Output: SaaS expanded into full ecosystem (beyond POS).  

---

## Final Notes
- **Every phase must ship as standalone (MVP-ready)**.  
- **Modules communicate only via Events/Services**.  
- **Multi-language + RTL** required from Phase 1 onwards.  
- **Tests & Docs** mandatory before merging to `main`.  

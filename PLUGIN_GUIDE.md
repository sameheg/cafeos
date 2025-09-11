# Plugin Development Guide

## Overview
The Marketplace module allows third-party developers to build and publish plugins that extend EliteSaaS functionality.

## Plugin Structure
```
plugin-name/
  ├── composer.json
  ├── src/
  │   ├── ServiceProvider.php
  │   ├── Controllers/
  │   ├── Models/
  │   └── routes.php
  ├── resources/
  │   ├── views/
  │   └── lang/
  └── tests/
```

## Lifecycle
1. **Install** → Tenant installs plugin from Marketplace.  
2. **Activate** → Plugin registers ServiceProvider.  
3. **Update** → Plugin updates via composer or API.  
4. **Deactivate** → Disable but keep data.  
5. **Uninstall** → Remove plugin and clean data.  

## API Contracts
- Plugins must expose a `manifest.json` describing:  
  - Name, Version, Author  
  - Permissions required  
  - Events subscribed/published  

## Example manifest.json
```json
{
  "name": "KitchenDisplay",
  "version": "1.0.0",
  "author": "VendorX",
  "permissions": ["orders.read", "orders.update"],
  "events": {
    "subscribe": ["order.created"],
    "publish": ["order.completed"]
  }
}
```

## Distribution
- Plugins submitted via Marketplace Vendor portal.  
- Revenue share model configurable in Billing.  

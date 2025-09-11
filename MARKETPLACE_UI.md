# Marketplace UI

## Overview
Describes the App Store-like experience for tenants.

## Features
- Browse plugins by category
- Search & filter
- Install/uninstall modules
- Reviews & ratings

## Flow
```mermaid
flowchart TD
    Tenant --> MarketplaceUI
    MarketplaceUI --> PluginDetails
    MarketplaceUI --> InstallProcess
    InstallProcess --> TenantSystem
```

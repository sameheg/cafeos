# Content Internationalization (i18n)

## Overview
- This section outlines the primary goals and scope of Content I18N.

## Prerequisites
- Familiarity with basic Content I18N concepts and system requirements is recommended.

## Setup
- Follow these steps to configure and enable Content I18N in your environment.

## Usage
- Instructions and examples for applying Content I18N in day-to-day operations.

## References
- Additional resources and documentation about Content I18N for further learning.


## Overview
Handles multi-language content, translations, and RTL support.

## Features
- Language fallback (e.g., ar → en).
- RTL support for Arabic, Hebrew.
- JSON-based translation files.
- Tenant-specific branding & translations.

## Flow
```mermaid
flowchart TD
    User --> UI
    UI --> i18n[Translation Layer]
    i18n --> DefaultLang[Fallback Language]
    i18n --> TenantLang[Tenant Custom Language]
```

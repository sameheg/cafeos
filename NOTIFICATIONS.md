# Notifications

## Overview
Manages delivery of notifications across channels.

## Channels
- Email
- SMS (Twilio)
- Push Notifications (PWA)
- In-App Alerts

## Flow
```mermaid
flowchart TD
    EventBus --> Notifications
    Notifications --> Email
    Notifications --> SMS
    Notifications --> Push
    Notifications --> InApp
```

# Reservation Layout

## Overview
Defines table layout UI for reservations.

## Features
- Drag-and-drop table placement
- Zone mapping (indoor, outdoor, VIP)
- Real-time availability view

## Flow
```mermaid
flowchart TD
    TenantAdmin --> LayoutDesigner
    LayoutDesigner --> ReservationSystem
    ReservationSystem --> POS
```

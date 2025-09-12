# Metrics & KPIs

This document lists core metrics surfaced in dashboards and reports.

## POS

- **daily_sales**: Sum of POS order totals for the current day.
- **queue_depth**: Number of pending jobs in the transaction queue.

## CRM

- **open_tickets**: Count of unresolved customer tickets.

## Reservations

- **reservation_turnover**: Reservations per table per day.

Each KPI should be calculated through a dedicated query class and cached for
one minute to keep dashboards responsive.


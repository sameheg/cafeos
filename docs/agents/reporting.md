# Reporting Agent

The Reporting module provides analytics and forecasting features.

## Forecast Service

`ForecastService` aggregates sales and inventory data to project future performance.

## Real-time Endpoint

- **GET** `/api/analytics/realtime`
  - Streams current sales and forecast data using Server-Sent Events.

## Frontend

JavaScript resources under `resources/js/analytics` consume the realtime stream to render live charts.

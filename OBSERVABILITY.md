# Observability

## Overview
Ensures deep visibility across services using logs, metrics, and traces.

## Components
- **Logs** → ELK Stack
- **Metrics** → Prometheus + Grafana
- **Tracing** → OpenTelemetry + Jaeger

## Flow
```mermaid
flowchart TD
    App --> Logs
    App --> Metrics
    App --> Traces

    Logs --> ELK[ELK Stack]
    Metrics --> Grafana
    Traces --> Jaeger
```

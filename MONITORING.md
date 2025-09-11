# Monitoring & Alerting Guide

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


## Tools
- **Sentry** → error tracking.  
- **ELK Stack** (Elasticsearch, Logstash, Kibana) → centralized logging.  
- **Prometheus + Grafana** → metrics and dashboards.  

## Alerts
- Slack/Email alerts for critical errors.  
- Threshold alerts for high CPU/memory usage.  
- DB replication lag alerts.  

## Setup Examples
### Sentry
Add DSN to `.env`:
```env
SENTRY_LARAVEL_DSN=https://yourdsn@sentry.io/projectid
```

### Prometheus Exporter
Deploy exporter sidecar for Laravel app.  

### Grafana
Import dashboard templates for Laravel + MySQL + Redis.

## See Also
- [Monitoring Flow](MONITORING_FLOW.md)
- [Observability](OBSERVABILITY.md)

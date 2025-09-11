<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
## Table of Contents

- [Monitoring & Alerting Guide](#monitoring--alerting-guide)
  - [Overview](#overview)
  - [Prerequisites](#prerequisites)
  - [Setup](#setup)
  - [Usage](#usage)
  - [References](#references)
  - [Tools](#tools)
  - [Alerts](#alerts)
  - [Setup Examples](#setup-examples)
    - [Sentry](#sentry)
    - [Prometheus Exporter](#prometheus-exporter)
    - [Grafana](#grafana)
  - [See Also](#see-also)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# Monitoring & Alerting Guide

## Overview
- This section outlines the primary goals and scope of Monitoring.

## Prerequisites
- Familiarity with basic Monitoring concepts and system requirements is recommended.

## Setup
- Follow these steps to configure and enable Monitoring in your environment.

## Usage
- Instructions and examples for applying Monitoring in day-to-day operations.

## References
- Additional resources and documentation about Monitoring for further learning.


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

## Related Docs
- [README.md](README.md)
- [MASTER_INDEX.md](MASTER_INDEX.md)


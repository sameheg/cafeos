<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
## Table of Contents

- [DevOps Guide](#devops-guide)
  - [Overview](#overview)
  - [Prerequisites](#prerequisites)
  - [Setup](#setup)
  - [Usage](#usage)
  - [References](#references)
  - [Local Setup](#local-setup)
  - [Production Setup](#production-setup)
  - [CI/CD](#cicd)
    - [Pipeline Diagram](#pipeline-diagram)
  - [Monitoring](#monitoring)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# DevOps Guide

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


## Local Setup
- Docker Compose with PHP 8.4, MySQL, Redis, Nginx.  
- Commands:  
```bash
docker compose up -d --build
```

## Production Setup
- Kubernetes cluster.  
- Helm charts for deployments.  
- Horizontal Pod Autoscaler.  

## CI/CD
- GitHub Actions workflow:  
  - Lint → Test → Build → Deploy.  
- Rollback strategies.  

### Pipeline Diagram
```mermaid
flowchart LR
    A[Developer Push] --> B[GitHub Actions Trigger]
    B --> C[Composer Install & NPM CI]
    C --> D[Run Tests: PHP + JS + E2E]
    D --> E{All Tests Pass?}
    E -- No --> F[Fail Pipeline & Notify]
    E -- Yes --> G[Build Docker Image]
    G --> H[Push to Container Registry]
    H --> I[Deploy to Kubernetes via Helm]
    I --> J[Run Migrations & Seed]
    J --> K[System Live]
```

## Monitoring
- Sentry for error tracking.  
- ELK stack for logs.  
- Prometheus + Grafana for metrics.  

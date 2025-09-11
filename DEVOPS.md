# DevOps Guide

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

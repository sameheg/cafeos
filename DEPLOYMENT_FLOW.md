# Deployment Flow

## Overview
Describes how the system moves from developer commits to production deployment.

## Flow Diagram
```mermaid
flowchart TD
    Dev[Developer Commit] --> CI[CI Pipeline]
    CI --> Tests[Run Tests & Lint]
    Tests --> Build[Build Docker Image]
    Build --> Registry[Push to Container Registry]
    Registry --> CD[CD Pipeline]
    CD --> K8s[Deploy to Kubernetes Cluster]
    K8s --> LB[Load Balancer]
    LB --> Users[End Users]
```

## Notes
- GitHub Actions handles CI/CD.
- Docker images stored in container registry.
- Kubernetes used for production deployments.
- Helm charts manage application releases.

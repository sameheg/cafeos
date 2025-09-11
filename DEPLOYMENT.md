# Deployment Guide

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


## Secrets Management
- Store sensitive data in GitHub Actions secrets or Kubernetes secrets.  
- Examples:
  - STRIPE_KEY
  - STRIPE_SECRET
  - DB_PASSWORD
  - SENTRY_DSN

## Deployment Environments
- **Development**: Local with Docker Compose.  
- **Staging**: Kubernetes cluster with staging domain.  
- **Production**: Multi-AZ Kubernetes with autoscaling.  

## Steps
1. Push to `main` branch triggers GitHub Actions.  
2. CI/CD pipeline builds image and runs tests.  
3. Image deployed to Kubernetes via Helm.  

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
## Table of Contents

- [Scaling & High Availability Guide](#scaling--high-availability-guide)
  - [Overview](#overview)
  - [Prerequisites](#prerequisites)
  - [Setup](#setup)
  - [Usage](#usage)
  - [References](#references)
  - [Horizontal Scaling](#horizontal-scaling)
  - [Database Scaling](#database-scaling)
  - [Redis Scaling](#redis-scaling)
  - [File Storage](#file-storage)
  - [High Availability](#high-availability)
  - [Disaster Recovery](#disaster-recovery)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# Scaling & High Availability Guide

## Overview
- This section outlines the primary goals and scope of Scaling.

## Prerequisites
- Familiarity with basic Scaling concepts and system requirements is recommended.

## Setup
- Follow these steps to configure and enable Scaling in your environment.

## Usage
- Instructions and examples for applying Scaling in day-to-day operations.

## References
- Additional resources and documentation about Scaling for further learning.


## Horizontal Scaling
- Multiple app containers behind load balancer.  
- Nginx/HAProxy for load distribution.  

## Database Scaling
- Read replicas for MySQL/PostgreSQL.  
- Partitioning or sharding for large tenants.  
- ProxySQL for routing queries.  

## Redis Scaling
- Sentinel for HA.  
- Cluster mode for sharding.  

## File Storage
- Use S3-compatible storage (AWS S3, MinIO).  
- CDN for static assets.  

## High Availability
- Deploy across multiple availability zones.  
- Automated backups + point-in-time recovery.  

## Disaster Recovery
- RPO < 15 minutes.  
- RTO < 1 hour.  

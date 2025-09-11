# Multi-Region Strategy

## Overview
Ensures high availability across regions.

## Approaches
- Active/Active → traffic split across regions.
- Active/Passive → failover to backup region.

## Tools
- Global DNS load balancing
- Cloud provider replication

## Diagram
```mermaid
flowchart TD
    Users --> DNS[Global DNS]
    DNS --> Region1
    DNS --> Region2

    Region1 --> DB1[(DB)]
    Region2 --> DB2[(DB)]
```

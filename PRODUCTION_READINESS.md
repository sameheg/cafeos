# Production Readiness Checklist

- [ ] DB migrations pass cleanly  
- [ ] Horizon workers running & monitored  
- [ ] Queue workers ≥ 2 × CPU cores  
- [ ] Redis cluster with failover  
- [ ] WebSockets secured (TLS, auth)  
- [ ] S3 storage with lifecycle policies  
- [ ] Billing webhooks validated  
- [ ] Observability: Sentry + Prometheus active  
- [ ] Backups tested daily  
- [ ] Disaster recovery RTO < 30 min

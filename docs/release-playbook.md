# Release Playbook

## Pre-deploy
- Verify new database migrations have matching `down` methods.
- Guard schema changes with appropriate feature flags (e.g. `POS_MODULE_ENABLED`).
- Toggle features for target tenants prior to rollout.

## Deploy
- Execute `scripts/deploy.sh` to perform a blue/green deployment.
- The script provisions the inactive stack and runs `scripts/smoke_test.sh` against `/health` and `/metrics`.
- On success, route traffic to the new stack; on failure the script rolls back automatically.

## Post-deploy
- Monitor application metrics and health checks.
- Keep the previous stack running until confidence is high, then tear it down.
- Re-enable feature flags if rollback occurs.

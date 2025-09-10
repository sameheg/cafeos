# Runbooks

## Database Connection Failures
1. Check environment variables `DB_HOST`, `DB_PORT`, and credentials.
2. Verify the database service is running and reachable.
3. Review logs for connection errors.

## Queue Backlog
1. Inspect queue metrics via `/metrics` and Horizon dashboard.
2. Ensure workers are running: `php artisan queue:work` or supervisor.
3. Scale workers or investigate failing jobs.

## WebSocket Outages
1. Check Reverb/Pusher health at the configured `WS_HEALTH_URL`.
2. Restart the websocket service if unresponsive.
3. Validate network rules and credentials.

## Scheduler Stalled
1. Confirm `php artisan schedule:run` is executing via cron.
2. Check `scheduler:heartbeat` cache key via `/health`.
3. Review scheduler logs for exceptions.


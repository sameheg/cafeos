# Setup Guide

## Local Development
```bash
cp .env.example .env
composer install
npm ci
php artisan key:generate
php artisan migrate --seed
npm run dev
```

## Codex Environment
Use [CODEX_SETUP.md](CODEX_SETUP.md) to bootstrap an environment in ChatGPT Codex.

## Production Notes
- Queues: Redis + Horizon
- Cache: Redis/Memcached
- WebSockets: Reverb or Pusher
- Storage: S3-compatible bucket
- Observability: Sentry + Prometheus

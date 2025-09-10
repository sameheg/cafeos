# Codex Environment — Setup Script (paste this in Codex → Environments → Setup Script)

```bash
#!/usr/bin/env bash
set -euo pipefail
export DEBIAN_FRONTEND=noninteractive

# System deps
apt-get update -y
apt-get install -y git unzip curl sqlite3 \
  php php-cli php-mbstring php-xml php-curl php-zip php-sqlite3 php-bcmath php-gd php-intl

# Composer
curl -fsSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Optional: accelerate GitHub API
# composer config -g github-oauth.github.com "$GITHUB_TOKEN" || true

# Node 20
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs

# App bootstrap (repo already cloned as CWD)
cp -n .env.example .env || true

# SQLite for sandbox speed
mkdir -p database && : > database/database.sqlite
sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
sed -i 's|^DB_DATABASE=.*|DB_DATABASE=./database/database.sqlite|' .env
sed -i 's/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=sync/' .env || true
sed -i 's/^CACHE_DRIVER=.*/CACHE_DRIVER=file/' .env || true
sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env || true
sed -i 's/^BROADCAST_DRIVER=.*/BROADCAST_DRIVER=log/' .env || true
sed -i 's/^MAIL_MAILER=.*/MAIL_MAILER=log/' .env || true
sed -i 's/^APP_ENV=.*/APP_ENV=testing/' .env || true
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=true/' .env || true

# Install deps (cache now while online)
composer install --no-interaction --prefer-dist --no-progress
npm ci --no-audit --no-fund

# Laravel warmups
php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optional: build assets (skip if not needed)
npm run build || true

# Quick smoke tests (fail-soft)
php artisan test --testsuite=Feature --stop-on-failure || php artisan test || true

echo "✅ Codex setup: deps cached, DB ready, caches warmed."
```

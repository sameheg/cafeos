# Codex Setup Script (Fast)

```bash
#!/usr/bin/env bash
set -euo pipefail

apt-get update -y
apt-get install -y git unzip curl sqlite3 \
  php php-cli php-mbstring php-xml php-curl php-zip php-sqlite3 php-bcmath php-gd php-intl

curl -fsSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt-get install -y nodejs

cp -n .env.example .env || true
mkdir -p database && : > database/database.sqlite
sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
sed -i 's|^DB_DATABASE=.*|DB_DATABASE=./database/database.sqlite|' .env

composer install --no-interaction --prefer-dist --no-progress
npm ci --no-audit --no-fund

php artisan key:generate
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:clear || true

echo "✅ Codex setup complete (CafeOS Elite)."
```

#!/usr/bin/env bash
set -euo pipefail

if [ -z "${GITHUB_TOKEN:-}" ]; then
  echo "GITHUB_TOKEN environment variable is required" >&2
  exit 1
fi

composer config --global github-oauth.github.com "$GITHUB_TOKEN"
composer update --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
zip -r build.zip . -x ".git/*" "tests/*" "node_modules/*"


# Local Development Setup

## Prerequisites
- PHP 8.4
- Composer
- Node.js 20+
- Docker & Docker Compose
- MySQL/Redis

## Steps
1. Clone repo
2. Copy .env.example → .env
3. Run docker-compose up -d
4. Run composer install && npm install
5. Run php artisan migrate --seed
6. Open http://localhost:8000

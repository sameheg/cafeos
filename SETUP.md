# Local Dev Setup

```bash
cp .env.example .env
composer install
npm ci
php artisan key:generate
php artisan migrate
npm run dev
```

**SQLite quick tests**
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

**Queues/WS (dev)**
- `php artisan horizon`
- `php artisan reverb:start` (or configure Pusher)

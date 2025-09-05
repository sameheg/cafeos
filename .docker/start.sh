#!/bin/sh
set -e

if [ ! -f /var/www/html/vendor/autoload.php ]; then
    composer install --no-interaction --prefer-dist
fi

php-fpm &
php artisan serve --host=0.0.0.0 --port=8000

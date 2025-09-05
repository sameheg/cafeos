FROM php:8.0-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Copy initialization scripts
COPY .docker/start.sh /usr/local/bin/start.sh
COPY .docker/queue-worker.sh /usr/local/bin/queue-worker.sh
RUN chmod +x /usr/local/bin/start.sh /usr/local/bin/queue-worker.sh

EXPOSE 8000
CMD ["start.sh"]

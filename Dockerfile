FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev curl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

(CSS/JS)
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm ci && npm run build

Laravel
RUN chmod -R 775 storage bootstrap/cache

Render
CMD php artisan config:clear && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
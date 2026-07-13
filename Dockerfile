# syntax=docker/dockerfile:1

# ------------------------------------------------------------
# 1) Build the standalone React/Vite frontend
# ------------------------------------------------------------
FROM node:22-alpine AS frontend-builder
WORKDIR /app/frontend

COPY frontend/package*.json ./
RUN npm install --no-audit --no-fund

COPY frontend/ ./
ARG VITE_API_URL=/
ENV VITE_API_URL=${VITE_API_URL}
RUN npm run build

# ------------------------------------------------------------
# 2) Install optimized Laravel dependencies
# ------------------------------------------------------------
FROM composer:2 AS vendor-builder
WORKDIR /app/backend

COPY backend/composer.json backend/composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

COPY backend/ ./
RUN composer dump-autoload --no-dev --optimize --classmap-authoritative

# ------------------------------------------------------------
# 3) Runtime: PHP-FPM + Nginx + Supervisor
# ------------------------------------------------------------
FROM php:8.3-fpm-bookworm

ENV APP_ENV=production \
    APP_DEBUG=false \
    PORT=10000

WORKDIR /var/www/backend

RUN apt-get update && apt-get install -y --no-install-recommends \
        nginx \
        supervisor \
        curl \
        unzip \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libwebp-dev \
        libzip-dev \
        libicu-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo_mysql \
        pdo_pgsql \
        xml \
        zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=vendor-builder /app/backend /var/www/backend
COPY --from=frontend-builder /app/frontend/dist /var/www/frontend

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/99-grihnirmaan.ini
COPY docker/start.sh /usr/local/bin/start-container

RUN chmod +x /usr/local/bin/start-container \
    && mkdir -p \
        /run/nginx \
        /var/log/supervisor \
        /var/www/backend/storage/framework/cache/data \
        /var/www/backend/storage/framework/sessions \
        /var/www/backend/storage/framework/views \
        /var/www/backend/storage/logs \
        /var/www/backend/bootstrap/cache \
    && chown -R www-data:www-data \
        /var/www/backend/storage \
        /var/www/backend/bootstrap/cache

EXPOSE 10000

HEALTHCHECK --interval=30s --timeout=5s --start-period=30s --retries=3 \
    CMD curl -fsS http://127.0.0.1:${PORT}/api/health || exit 1

CMD ["/usr/local/bin/start-container"]

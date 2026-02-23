FROM php:8.2-fpm

# Install system dependencies + build deps for PECL (redis)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    fcgiwrap \
    $PHPIZE_DEPS \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd opcache

# Install Redis PHP extension (PECL) — gerekli build araçları image'da mevcut
RUN pecl install redis \
    && docker-php-ext-enable redis \
    && php -m | grep -q redis || (echo "Redis extension yüklenemedi!" && exit 1)

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy PHP-FPM pool configuration
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Copy OPcache config
RUN echo "opcache.enable=1\n\
opcache.memory_consumption=128\n\
opcache.interned_strings_buffer=16\n\
opcache.max_accelerated_files=10000\n\
opcache.validate_timestamps=0\n\
opcache.revalidate_freq=0" > /usr/local/etc/php/conf.d/opcache.ini

# Simple php-fpm health check script
RUN echo '#!/bin/sh\nCGI_STATUS=$(cgi-fcgi -bind -connect 127.0.0.1:9000 2>/dev/null)\nif [ $? -eq 0 ]; then exit 0; else exit 1; fi' > /usr/local/bin/php-fpm-healthcheck && chmod +x /usr/local/bin/php-fpm-healthcheck || true

# Set working directory
WORKDIR /var/www

# Entrypoint: perms + optional composer/key
COPY docker/entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache

EXPOSE 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php-fpm"]

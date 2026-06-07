FROM php:8.4-fpm

# Extensions système nécessaires
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libicu-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Extensions PHP
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    intl \
    opcache

# pcov pour la couverture de tests
RUN pecl install pcov && docker-php-ext-enable pcov

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm"]
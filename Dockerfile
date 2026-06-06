FROM php:8.4-cli

# Extensions courantes
RUN docker-php-ext-install pdo pdo_mysql

# pcov pour la couverture de tests
RUN pecl install pcov && docker-php-ext-enable pcov

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
RUN composer install

CMD ["tail", "-f", "/dev/null"]
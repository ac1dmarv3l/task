FROM php:8.4-fpm-alpine

RUN apk update
RUN apk --no-cache add \
    git \
    curl \
    zip \
    unzip \
    && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /app

COPY ./project /app

RUN composer install --no-dev --optimize-autoloader

RUN composer dump-autoload --optimize

RUN echo "error_log = /var/log/php/error.log" >> /usr/local/etc/php/php.ini

RUN echo "log_errors = On" >> /usr/local/etc/php/php.ini \
    && echo "error_reporting = E_ALL" >> /usr/local/etc/php/php.ini

RUN apk --no-cache add postgresql-dev \
    php84-pdo_pgsql \
    && docker-php-ext-install pdo_pgsql && docker-php-ext-enable pdo_pgsql

RUN chown -R www-data:www-data /app

USER www-data

EXPOSE 9000
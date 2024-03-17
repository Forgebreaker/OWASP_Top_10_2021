FROM php:8.0-apache

RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    redis-server

RUN pecl install redis \
    && docker-php-ext-enable redis

WORKDIR /var/www/html/

COPY ./resource .

RUN chown -R www-data:www-data /var/www/html
RUN find . -type d -exec chmod 750 {} \;
RUN find . -type f -exec chmod 640 {} \;







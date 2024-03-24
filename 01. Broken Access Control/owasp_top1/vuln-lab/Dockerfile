FROM php:8.0-apache

WORKDIR /var/www/html/

COPY ./resource .

RUN chown -R www-data:www-data /var/www/html
RUN chmod 750 /var/www/html
RUN find . -type f -exec chmod 640 {} \;
RUN find . -type d -exec chmod 750 {} \;

RUN apt-get update && apt-get install -y sqlite3 libsqlite3-dev




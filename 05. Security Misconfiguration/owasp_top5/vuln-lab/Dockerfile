FROM php:7.0-apache

WORKDIR /var/www/html/

COPY ./resource .

RUN chown -R www-data:www-data /var/www/html
RUN find . -type d -exec chmod 750 {} \;
RUN find . -type f -exec chmod 640 {} \;

RUN echo "Bounty_Boys{Captured_The_Flag}" > /flag.txt







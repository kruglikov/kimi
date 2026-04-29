FROM php:8.0-apache

RUN docker-php-ext-install mysqli \
 && a2enmod rewrite

COPY vhost.conf /etc/apache2/sites-available/000-default.conf

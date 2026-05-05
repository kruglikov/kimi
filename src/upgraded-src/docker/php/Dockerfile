FROM php:8.5-apache

RUN docker-php-ext-install mysqli \
 && a2enmod rewrite

COPY vhost.conf /etc/apache2/sites-available/000-default.conf
COPY zz-mysqli-socket.ini /usr/local/etc/php/conf.d/zz-mysqli-socket.ini

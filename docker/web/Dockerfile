FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
        libldap2-dev \
        libonig-dev \
    && docker-php-ext-configure ldap \
    && docker-php-ext-install mysqli pdo_mysql ldap mbstring \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY apache.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini /usr/local/etc/php/conf.d/docker-custom.ini

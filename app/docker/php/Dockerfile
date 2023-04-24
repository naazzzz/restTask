FROM php:7.4-fpm-alpine

RUN apk add --no-cache zip libzip-dev
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql 
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

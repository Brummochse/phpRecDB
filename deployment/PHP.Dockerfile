FROM php:8.3-apache

# Install necessary PHP extensions
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install mysqli pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy custom php.ini if needed
COPY ./php.ini /usr/local/etc/php/

WORKDIR /var/www/html

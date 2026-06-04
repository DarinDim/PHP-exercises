FROM php:8.2-apache

# Install the required system library for the zip extension
RUN apt-get update && apt-get install -y \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Install only the missing extensions (json and session are built-in)
RUN docker-php-ext-install pdo pdo_mysql mysqli zip

# Enable rewrite engine for clean URLs
RUN a2enmod rewrite

WORKDIR /var/www/html
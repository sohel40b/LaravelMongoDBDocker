# Use the official PHP image as base
FROM php:8.1-fpm

# Install additional PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    vim \
    libcurl4-openssl-dev pkg-config libssl-dev \
    && docker-php-ext-install pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install mongodb and php extensions
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Set working directory
WORKDIR /var/www/html

# Copy Laravel application files
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html/src/storage /var/www/html/src/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
FROM php:8.2.3-fpm

# Copy composer.lock and composer.json
COPY src/composer.lock src/composer.json src/var/www/

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    jpegoptim optipng pngquant gifsicle \
    curl \
    libcurl4-openssl-dev pkg-config libssl-dev

# Install mongodb and php extensions
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql

RUN set -e; \
    docker-php-ext-configure gd --with-jpeg  --with-freetype; \
    docker-php-ext-install -j$(nproc) gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY src /var/www

# Copy existing application directory permissions
COPY --chown=www:www src /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Apache configuration
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy composer.json
COPY src/composer.json /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev pkg-config libssl-dev

# Install mongodb and php extensions
RUN pecl install mongodb && docker-php-ext-enable mongodb

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY src /var/www/html

# Copy existing application directory permissions
COPY --chown=www:www src /var/www/html

# Change current user to www
USER www

# Expose port 80
EXPOSE 80

# Start Apache web server
CMD ["apache2-foreground"]
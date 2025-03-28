FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files into the container
COPY . .

# Run Composer install (WITH dev dependencies)
RUN composer install --no-interaction --prefer-dist

# Expose Apache port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]

# Use an official PHP image with Apache
FROM php:8.1.2-apache

# Install MySQL extension for PHP
RUN docker-php-ext-install mysqli

# Copy website files into the container's web root
COPY src/ /var/www/html/

# Set correct permissions (optional but recommended)
RUN chown -R www-data:www-data /var/www/html

# Copy the Apache configuration file into the container
COPY apache-config/apache2.conf /etc/apache2/apache2.conf

# Copy virtual host configuration (if you have custom VHosts)
COPY apache-config/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy url rewriting rules (.htaccess)
COPY apache-config/.htaccess /var/www/html/.htaccess

# Enable mod rewrite
RUN a2enmod rewrite

# Expose port 80 for HTTP
EXPOSE 80

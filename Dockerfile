FROM php:8.2-apache

# 1. Instalar dependencias de Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 2. Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 3. Copiar el proyecto al contenedor
COPY . /var/www/html
WORKDIR /var/www/html

# 4. Configurar Apache
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite && a2ensite 000-default.conf

# 5. Permisos y dependencias
RUN chmod -R 775 storage bootstrap/cache
RUN touch database/database.sqlite
RUN composer install --no-dev --optimize-autoloader

# 6. Puerto y comando de inicio
EXPOSE 80
CMD ["apache2-foreground"]

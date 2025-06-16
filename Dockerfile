FROM php:8.2-apache

# Instalar dependencias de Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar el proyecto al contenedor
COPY . /var/www/html

# Establecer permisos y instalar dependencias
WORKDIR /var/www/html
RUN chmod -R 775 storage bootstrap/cache
RUN composer install --no-dev --optimize-autoloader

# Configurar Apache para Laravel
RUN a2enmod rewrite
COPY .docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Puerto expuesto
EXPOSE 80
CMD ["apache2-foreground"]

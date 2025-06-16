FROM php:8.2-apache

# 1. Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip \
    && rm -rf /var/lib/apt/lists/*

# Configuración de Apache para tu estructura
RUN a2enmod rewrite && \
    echo "<Directory /public>" > /etc/apache2/conf-available/laravel.conf && \
    echo "    Options FollowSymLinks" >> /etc/apache2/conf-available/laravel.conf && \
    echo "    AllowOverride All" >> /etc/apache2/conf-available/laravel.conf && \
    echo "    Require all granted" >> /etc/apache2/conf-available/laravel.conf && \
    echo "</Directory>" >> /etc/apache2/conf-available/laravel.conf && \
    a2enconf laravel

WORKDIR /var/www/html

# 3. Instalar Composer (con mayor memoria)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1

# 4. Copiar todo el proyecto (manteniendo tu estructura exacta)
COPY . .

# 5. Configurar permisos sin alterar estructura
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    [ -f database/database.sqlite ] || touch database/database.sqlite && \
    chmod 666 database/database.sqlite

# 6. Instalar dependencias
RUN composer install --no-dev --optimize-autoloader --no-scripts

# 7. Configurar puerto dinámico para Render
EXPOSE ${PORT:-80}
CMD ["apache2-foreground"]
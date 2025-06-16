# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Directorio de trabajo
WORKDIR /var/www/html

# Instala dependencias de Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite

# Copia el proyecto
COPY . .

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala dependencias de Laravel (sin dev)
RUN composer install --optimize-autoloader --no-dev

# Permisos para SQLite
RUN chmod 777 /var/www/html/database
RUN chmod 666 /var/www/html/database/database.sqlite

# Ejecuta migraciones y seeds (opcional)
RUN php artisan migrate --force
# RUN php artisan db:seed --force (si necesitas datos iniciales)

# Expone el puerto 80 (para Apache)
EXPOSE 80

# Inicia Apache
CMD ["apache2-foreground"]
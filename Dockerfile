# Usa una imagen oficial de PHP con Apache
FROM php:8.2-apache

# Directorio de trabajo
WORKDIR /var/www/html

# Instala dependencias del sistema + SQLite (con librerías de desarrollo)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    pkg-config \
    && docker-php-ext-install pdo pdo_sqlite

# Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el proyecto (excluyendo lo innecesario con .dockerignore)
COPY . .

# Instala dependencias de Laravel (sin dev)
RUN composer install --optimize-autoloader --no-dev

# Permisos para SQLite
RUN mkdir -p /var/www/html/database \
    && touch /var/www/html/database/database.sqlite \
    && chmod 777 /var/www/html/database \
    && chmod 666 /var/www/html/database/database.sqlite

# Ejecuta migraciones (opcional)
# RUN php artisan migrate --force

# Expone el puerto 80
EXPOSE 80

# Inicia Apache
CMD ["apache2-foreground"]
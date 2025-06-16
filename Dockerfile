FROM php:8.2-apache

WORKDIR /var/www/html

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git unzip sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .

# Configuración dinámica para Render
RUN echo "Listen 80" > /etc/apache2/ports.conf && \
    sed -i 's/80/${PORT}/g' /etc/apache2/sites-enabled/000-default.conf && \
    sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf

# Instalar dependencias de Laravel
RUN composer install --optimize-autoloader --no-dev

# Permisos para SQLite
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod 666 database/database.sqlite

# Script de inicio adaptado para Render
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE $PORT
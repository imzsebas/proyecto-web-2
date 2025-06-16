FROM php:8.2-apache

WORKDIR /var/www/html

# Instala dependencias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    pkg-config \
    && docker-php-ext-install pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .

# Configura Apache para Render (¡Clave!)
RUN echo "Listen \${PORT:-80}" > /etc/apache2/ports.conf && \
    sed -i 's/:80\/>/:${PORT:-80}\/>/g' /etc/apache2/sites-enabled/000-default.conf

# Instala Laravel y permisos
RUN composer install --optimize-autoloader --no-dev && \
    mkdir -p /var/www/html/database && \
    touch /var/www/html/database/database.sqlite && \
    chmod 666 /var/www/html/database/database.sqlite

# Expone el puerto (usa la misma variable)
EXPOSE ${PORT:-80}

CMD ["apache2-foreground"]
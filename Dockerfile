# Usar imagen oficial de PHP con Apache
FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Configurar Apache para Laravel
RUN echo "<VirtualHost *:80>" > /etc/apache2/sites-available/laravel.conf && \
    echo "    DocumentRoot /var/www/html/public" >> /etc/apache2/sites-available/laravel.conf && \
    echo "    <Directory /var/www/html/public>" >> /etc/apache2/sites-available/laravel.conf && \
    echo "        AllowOverride All" >> /etc/apache2/sites-available/laravel.conf && \
    echo "        Require all granted" >> /etc/apache2/sites-available/laravel.conf && \
    echo "    </Directory>" >> /etc/apache2/sites-available/laravel.conf && \
    echo "    ErrorLog \${APACHE_LOG_DIR}/error.log" >> /etc/apache2/sites-available/laravel.conf && \
    echo "    CustomLog \${APACHE_LOG_DIR}/access.log combined" >> /etc/apache2/sites-available/laravel.conf && \
    echo "</VirtualHost>" >> /etc/apache2/sites-available/laravel.conf

# Habilitar el sitio y deshabilitar el default
RUN a2ensite laravel.conf && a2dissite 000-default.conf

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar composer desde imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar SOLO los archivos de composer primero (para aprovechar cache de Docker)
COPY composer.json composer.lock ./

# Instalar dependencias de PHP (antes de copiar todo el código)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Ahora copiar el resto del proyecto (excluyendo vendor)
COPY . .

# Asegurar que no hay conflictos y re-instalar si es necesario
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Crear directorios necesarios
RUN mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/bootstrap/cache

# Crear archivo de base de datos SQLite si no existe
RUN mkdir -p /var/www/html/database && \
    touch /var/www/html/database/database.sqlite

# Configurar permisos (IMPORTANTE: hacer esto al final)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod 666 /var/www/html/database/database.sqlite

# Configurar variables de entorno por defecto
ENV APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr

# Script de inicialización
RUN echo '#!/bin/bash' > /usr/local/bin/start.sh && \
    echo 'set -e' >> /usr/local/bin/start.sh && \
    echo '' >> /usr/local/bin/start.sh && \
    echo '# Generar clave de aplicación si no existe' >> /usr/local/bin/start.sh && \
    echo 'if [ -z "$APP_KEY" ]; then' >> /usr/local/bin/start.sh && \
    echo '    php artisan key:generate --no-interaction' >> /usr/local/bin/start.sh && \
    echo 'fi' >> /usr/local/bin/start.sh && \
    echo '' >> /usr/local/bin/start.sh && \
    echo '# Ejecutar migraciones' >> /usr/local/bin/start.sh && \
    echo 'php artisan migrate --force --no-interaction || true' >> /usr/local/bin/start.sh && \
    echo '' >> /usr/local/bin/start.sh && \
    echo '# Limpiar y cachear configuraciones' >> /usr/local/bin/start.sh && \
    echo 'php artisan config:clear' >> /usr/local/bin/start.sh && \
    echo 'php artisan config:cache' >> /usr/local/bin/start.sh && \
    echo 'php artisan route:cache' >> /usr/local/bin/start.sh && \
    echo 'php artisan view:cache' >> /usr/local/bin/start.sh && \
    echo '' >> /usr/local/bin/start.sh && \
    echo '# Iniciar Apache' >> /usr/local/bin/start.sh && \
    echo 'exec apache2-foreground' >> /usr/local/bin/start.sh && \
    chmod +x /usr/local/bin/start.sh

# Exponer puerto 80
EXPOSE 80

# Comando de inicio
CMD ["/usr/local/bin/start.sh"]
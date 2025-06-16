FROM php:8.2-apache

WORKDIR /var/www/html

# Configuración crítica de Apache
RUN a2enmod rewrite && \
    echo "DirectoryIndex index.php" > /etc/apache2/conf-available/laravel.conf && \
    a2enconf laravel && \
    sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# 3. Copia TODO tu proyecto (incluyendo node_modules si es necesario)
COPY . .

# 4. Instala Composer (sin tocar tu vendor existente)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev --no-scripts

# 5. Configura permisos (ajusta según tus necesidades)
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && touch database/database.sqlite \
    && chmod 666 database/database.sqlite

# 6. Puerto dinámico para Render
EXPOSE ${PORT:-80}

# 7. Inicia Apache (servirá automáticamente desde /public)
CMD ["apache2-foreground"]
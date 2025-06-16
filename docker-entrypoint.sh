#!/bin/bash

# Configura el puerto dinámicamente
sed -i "s/\${PORT}/$PORT/g" /etc/apache2/sites-enabled/000-default.conf
sed -i "s/\${PORT}/$PORT/g" /etc/apache2/ports.conf

# Ejecuta migraciones (opcional)
php artisan migrate --force

# Inicia Apache
exec apache2-foreground
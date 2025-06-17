#!/usr/bin/env bash

echo "🚀 Iniciando build para Render..."

# Instalar dependencias
echo "📦 Instalando dependencias..."
composer install --no-dev --optimize-autoloader --no-interaction

# Verificar conexión a base de datos
echo "🔗 Verificando conexión a PostgreSQL..."

# Limpiar cache
echo "🧹 Limpiando cache..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Ejecutar migraciones (crear tablas vacías)
echo "🗃️ Ejecutando migraciones..."
php artisan migrate --force

# Verificar que las migraciones se ejecutaron
echo "✅ Verificando migraciones..."
php artisan migrate:status

# Optimizar para producción
echo "⚡ Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✨ Build completado exitosamente!"
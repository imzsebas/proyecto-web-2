#!/usr/bin/env bash
set -o errexit

echo "🚀 Iniciando build de MiRefugio..."

# Instalar dependencias
echo "📦 Instalando dependencias..."
composer install --no-dev --optimize-autoloader

# Crear base de datos SQLite en /tmp
echo "🗄️ Creando base de datos SQLite..."
touch /tmp/database.sqlite
chmod 666 /tmp/database.sqlite

# Limpiar cachés
echo "🧹 Limpiando cachés..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Generar clave si no existe
echo "🔑 Generando clave de aplicación..."
php artisan key:generate --force

# Ejecutar migraciones
echo "📊 Ejecutando migraciones..."
php artisan migrate --force --database=sqlite

# Crear cachés optimizados
echo "⚡ Creando cachés optimizados..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Crear enlace de storage
echo "🔗 Creando enlace de storage..."
php artisan storage:link

echo "✅ Build completado!"
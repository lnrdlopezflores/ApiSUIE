#!/usr/bin/env bash
# Salir si ocurre algún error
set -e

echo "Instalando dependencias de Composer..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Generando enlace simbólico para archivos..."
php artisan storage:link || true

echo "Limpiando y cacheando configuración..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Ejecutando migraciones de base de datos..."
php artisan migrate --force
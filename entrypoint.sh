#!/bin/bash

set -e
cd /var/www/html

# --- ARREGLA: CREA TODOS LOS DIRECTORIOS NECESARIOS ---
mkdir -p storage/framework/sessions
mkdir -p storage/framework/cache
mkdir -p storage/framework/views
mkdir -p storage/logs

# Caching, migraciones, etc.
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan migrate --force

# Schedule:run loop
while true; do
  php artisan schedule:run >> storage/logs/cron.log 2>&1
  sleep 60
done &

# Inicia Apache
exec apache2-foreground

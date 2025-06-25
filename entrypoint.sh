#!/bin/bash

set -e
cd /var/www/html

php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Ejecuta schedule:run cada minuto en segundo plano
while true; do
  php artisan schedule:run >> /dev/null 2>&1
  sleep 60
done &

# Inicia Apache en primer plano
exec apache2-foreground

#!/bin/bash

set -e
cd /var/www/html

php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan migrate --force

# Ejecuta schedule:run cada minuto en segundo plano
while true; do
  echo "=== $(date) Ejecutando cron ===" >> storage/logs/cron.log
  php artisan schedule:run >> storage/logs/cron.log 2>&1
  sleep 60
done &


# Inicia Apache en primer plano
exec apache2-foreground

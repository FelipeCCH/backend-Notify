#!/bin/bash

# Muestra los errores si algo falla
set -e

# Caching de configuración y vistas
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate

# Migraciones automáticas (opcional)
# php artisan migrate --force

# Inicia Apache en primer plano
exec apache2-foreground

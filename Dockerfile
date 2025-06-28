FROM php:8.2-apache

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Habilita mod_rewrite
RUN a2enmod rewrite

# Establece directorio de trabajo
WORKDIR /var/www/html

# Copia código fuente
COPY . .

# Configura Apache para servir desde /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Copia Composer desde imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instala dependencias (sin dev)
RUN composer install --no-dev --optimize-autoloader

# --- AJUSTE IMPORTANTE AQUÍ ---
# Crea los directorios requeridos antes de cambiar permisos
RUN mkdir -p storage/framework/sessions storage/framework/cache storage/framework/views storage/logs \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copia el script de entrada
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Usa el script como comando principal
CMD ["/usr/local/bin/entrypoint.sh"]

EXPOSE 80

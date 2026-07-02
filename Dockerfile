FROM php:8.3-fpm-alpine

# Instalar dependencias del sistema y extensiones de PHP requeridas por Laravel
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql bcmath

# Configurar Directorio de Trabajo
WORKDIR /var/www/html

# Copiar el código del proyecto
COPY . .

# Instalar dependencias de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Configurar permisos para Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copiar configuraciones de Nginx y Supervisor
COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]
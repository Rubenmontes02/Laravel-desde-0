# Imagen base: PHP 8.3 con PHP-FPM (el "motor" que ejecuta el código PHP).
# FPM = FastCGI Process Manager: recibe peticiones de Nginx y las procesa.
FROM php:8.4-fpm

# Dependencias del sistema que las extensiones de PHP necesitan para compilar/funcionar.
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Extensiones de PHP que Laravel necesita en tiempo de ejecución:
# - pdo_mysql: para hablar con MySQL desde Eloquent/PDO
# - mbstring: manejo de strings multibyte (UTF-8, etc.)
# - zip: para composer y algunos paquetes
RUN docker-php-ext-install pdo_mysql mbstring zip

# Composer (gestor de dependencias de PHP) copiado desde su propia imagen oficial.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# UID/GID de tu usuario en el host (ruben=1002). Renombramos el UID/GID del
# usuario "www-data" que ya trae la imagen para que coincida con el tuyo:
# así los archivos que cree el contenedor (o tú, via exec) ya nacen con el
# dueño correcto en tu disco, sin necesidad de "chown" manual nunca más.
ARG UID=1002
ARG GID=1002
RUN groupmod -g ${GID} www-data && usermod -u ${UID} -g ${GID} www-data

WORKDIR /var/www/html

# Copiamos primero solo los manifests de dependencias para aprovechar la cache de Docker:
# si composer.json/lock no cambian, Docker reutiliza esta capa y no reinstala nada.
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-interaction

# Ahora copiamos el resto del código de la aplicación.
COPY . .

RUN composer dump-autoload --optimize

# Todo el código pasa a ser propiedad de www-data (=tu UID 1002), no solo
# storage/bootstrap/cache: así cualquier archivo nuevo (migraciones, modelos,
# vistas...) que se cree ya sea vía "exec" o dentro del contenedor, es tuyo.
RUN chown -R www-data:www-data /var/www/html

# A partir de aquí, tanto "php-fpm" (abajo) como cualquier "docker compose exec"
# corren como este usuario en vez de como root.
USER www-data

EXPOSE 9000

CMD ["php-fpm"]

FROM php:8.2-apache

# Instalar extensiones necesarias (como pdo_mysql para MySQL)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar tu aplicación al servidor Apache
COPY . /var/www/html/

EXPOSE 80

FROM php:8.2-apache

# Instalar dependencias y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install intl mysqli pdo pdo_mysql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar tu proyecto al contenedor
COPY . /var/www/html/

# Configuración de Apache
RUN sed -i 's|DocumentRoot /var/www/html.*|DocumentRoot /var/www/html|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf
RUN mkdir -p /var/www/html/writable/{cache,debugbar,logs,session,uploads} \
    && chown -R www-data:www-data /var/www/html/writable \
    && chmod -R 775 /var/www/html/writable

FROM php:8.4-apache

# Habilita mod_rewrite
RUN a2enmod rewrite

# Instalando o pdo
RUN docker-php-ext-install pdo pdo_mysql

# Site
COPY ./conf/tecnofit.conf /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html

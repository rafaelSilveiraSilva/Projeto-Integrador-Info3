FROM php:8.2-apache

# Instala extensões necessárias para MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copia os arquivos do projeto para o servidor web
COPY . /var/www/html/

# Ajusta as permissões de acesso
RUN chown -R www-data:www-data /var/www/html

# Ativa o módulo de reescrita do Apache
RUN a2enmod rewrite

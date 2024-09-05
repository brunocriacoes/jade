# Usar a imagem oficial do PHP 8.2 com Apache
FROM php:8.2-apache

# Instalar dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho como /var/www/html
WORKDIR /var/www/html

# Copiar o conteúdo do projeto para o container
COPY ./src/v1 /var/www/html/v1
COPY ./src/assets /var/www/html/assets

# Instalar dependências do PHP (PHPMailer incluído)
RUN composer require phpmailer/phpmailer

# Desativar exibição de erros e ajustar o error_reporting
RUN echo "display_errors = Off" >> /usr/local/etc/php/conf.d/custom.ini
RUN echo "error_reporting = E_ALL & ~E_NOTICE & ~E_WARNING" >> /usr/local/etc/php/conf.d/custom.ini

# Habilitar o módulo de reescrita do Apache (necessário para .htaccess)
RUN a2enmod rewrite

# Expor a porta 80
EXPOSE 80

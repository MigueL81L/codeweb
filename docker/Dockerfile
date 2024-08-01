# Utiliza una imagen de PHP
FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y libzip-dev unzip git

# Instala extensiones de PHP
RUN docker-php-ext-install zip pdo pdo_mysql

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia los archivos de configuración de Composer
COPY composer.json composer.lock ./

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala dependencias de Composer
RUN composer install

# Copia el resto del proyecto
COPY . .

# Expone el puerto
EXPOSE 9000

# Inicia el servidor PHP
CMD ["php-fpm"]


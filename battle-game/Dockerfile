FROM php:8.2-apache

# Instalăm dependențele sistemului și extensiile PHP necesare pentru Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Activăm mod_rewrite pentru Apache (esențial pentru rutele din Laravel)
RUN a2enmod rewrite

# Schimbăm directorul principal Apache să arate către folderul /public din Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Setăm directorul de lucru in container
WORKDIR /var/www/html

# Copiem fisierele proiectului
COPY . .

#  Composer global in container
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# librariile PHP
RUN composer install --no-dev --optimize-autoloader

# permisiunile corecte pentru serverul web pe folderele de cache si storage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# portul pe care il ofera Render
EXPOSE 80

CMD ["apache2-foreground"]

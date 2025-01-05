FROM php:8.2-apache
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd \
    && docker-php-ext-install gd pdo pdo_mysql
WORKDIR /var/www/html
ADD . .
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
RUN a2enmod rewrite
COPY ./apache-laravel.conf /etc/apache2/sites-available/000-default.conf
RUN npm install
EXPOSE 80
CMD ["apache2-foreground"]


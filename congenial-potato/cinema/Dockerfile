FROM php:7.4-apache

LABEL org.opencontainers.image.authors="mshegolev@gmail.com"

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    libpng-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli 
RUN docker-php-ext-install gd && docker-php-ext-enable gd


COPY ./www /var/www/html/
WORKDIR /var/www/html/

# CMD [ "php", "./your-script.php" ]

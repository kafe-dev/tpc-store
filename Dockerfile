FROM php:8.3-apache

RUN apt update
RUN apt install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++

RUN docker-php-ext-install \
    bz2 \
    intl \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    mysqli

RUN mkdir /etc/apache2/ssl

COPY vhost-config/apache.conf /etc/apache2/sites-available/tpc-store.conf
COPY vhost-config/ssl.key /etc/apache2/ssl/ssl.key
COPY vhost-config/ssl.pem /etc/apache2/ssl/ssl.pem

RUN a2enmod rewrite headers ssl

RUN a2dissite 000-default.conf
RUN a2ensite tpc-store.conf

RUN service apache2 restart

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer
RUN composer self-update

RUN useradd -G www-data,root -u 1000 -d /home/devuser devuser
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser

EXPOSE 80

USER ROOT
WORKDIR /var/www/html/tpc-store
RUN chmod +x /init.sh
RUN ./init.sh
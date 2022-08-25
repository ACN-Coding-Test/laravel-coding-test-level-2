FROM php:8.0-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    libmemcached-dev \
    wget \
    libonig-dev \
    libzip-dev \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    curl \
    lua-zlib-dev \
    libmemcached-dev \
    nginx \
    redis-server

# Install php extensions
RUN docker-php-ext-install mbstring pdo_mysql zip exif pcntl gd

# Install Memcached
RUN mkdir -p /usr/src/php/ext/memcached
WORKDIR /usr/src/php/ext/memcached
RUN wget https://github.com/php-memcached-dev/php-memcached/archive/v3.2.0.zip; unzip /usr/src/php/ext/memcached/v3.2.0.zip
RUN mv /usr/src/php/ext/memcached/php-memcached-3.2.0/* /usr/src/php/ext/memcached/
RUN docker-php-ext-configure memcached && docker-php-ext-install memcached
# reset working dir
WORKDIR /var/www


RUN mkdir -p /usr/src/php/ext/redis
WORKDIR /usr/src/php/ext/redis
RUN curl -fsSL https://pecl.php.net/get/redis --ipv4 | tar xvz -C "/usr/src/php/ext/redis" --strip 1;
RUN docker-php-ext-configure redis && docker-php-ext-install redis
# reset working dir
WORKDIR /var/www


# Install supervisor
RUN apt-get install -y supervisor

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy code to /var/www
COPY --chown=www:www-data . /var/www

# add root to www group
RUN chmod -R ug+w /var/www/storage

# Copy nginx/php/supervisor configs
RUN cp docker/supervisor.conf /etc/supervisord.conf
RUN cp docker/php.ini /usr/local/etc/php/conf.d/app.ini
RUN cp docker/nginx.conf /etc/nginx/sites-enabled/default

# PHP Error Log Files
RUN mkdir /var/log/php
RUN touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

# Deployment steps
RUN composer install --optimize-autoloader --no-dev
RUN chmod +x /var/www/docker/run.sh

EXPOSE 80
ENTRYPOINT ["/var/www/docker/run.sh"]

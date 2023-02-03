FROM php:7.4-apache

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        wget \
        libzip-dev \
        git \
        libxml2-dev libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        zlib1g-dev \
        graphicsmagick \
        unzip \
		ghostscript && \
    pecl install xdebug-2.9.4 && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install -j$(nproc) pdo_mysql mysqli soap gd zip opcache intl && \
    docker-php-ext-enable xdebug && \
    echo 'always_populate_raw_post_data = -1\nmax_execution_time = 240\nmax_input_vars = 1500\nupload_max_filesize = 32M\npost_max_size = 32M\nmemory_limit=1024M' > /usr/local/etc/php/conf.d/typo3.ini && \
    echo 'zend_extension=xdebug.so\nxdebug.remote_enable=1\nxdebug.remote_autostart=1\nxdebug.remote_connect_back=0\nxdebug.remote_host=docker.for.mac.localhost\nxdebug.remote_handler=dbgp\nxdebug.max_nesting_level=1500' > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    a2enmod rewrite && \
    apt-get clean && \
    apt-get -y purge \
        libxml2-dev libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        zlib1g-dev \
        mysql-client && \
    rm -rf /var/lib/apt/lists/* /usr/src/*

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/bin --filename=composer && chmod +x /usr/bin/composer

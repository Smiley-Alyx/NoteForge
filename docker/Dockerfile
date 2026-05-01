FROM debian:bookworm-slim

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        curl \
        git \
        autoconf \
        bison \
        re2c \
        pkg-config \
        build-essential \
        libxml2-dev \
        libsqlite3-dev \
        libssl-dev \
        libcurl4-openssl-dev \
        libonig-dev \
        libzip-dev \
        libpq-dev \
        zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /usr/src

# Build PHP 8.5 from source.
RUN git clone --depth 1 --branch PHP-8.5 https://github.com/php/php-src.git php-src \
    && cd php-src \
    && ./buildconf --force \
    && ./configure \
        --prefix=/usr/local \
        --with-openssl \
        --with-zlib \
        --with-curl \
        --with-zip \
        --enable-mbstring \
        --enable-opcache \
        --with-pdo-pgsql \
        --with-pgsql \
    && make -j"$(nproc)" \
    && make install \
    && make clean

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Build Phalcon extension from source.
RUN git clone --depth 1 https://github.com/phalcon/cphalcon.git /usr/src/cphalcon \
    && cd /usr/src/cphalcon/ext \
    && /usr/local/bin/phpize \
    && ./configure --with-php-config=/usr/local/bin/php-config \
    && make -j"$(nproc)" \
    && make install \
    && mkdir -p /usr/local/etc/php/conf.d \
    && echo "extension=phalcon.so" > /usr/local/etc/php/conf.d/phalcon.ini

WORKDIR /var/www

RUN git config --global --add safe.directory /var/www

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]

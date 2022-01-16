ARG PHP_VERSION=8.0

FROM php:${PHP_VERSION}-apache AS base
ENV PATH=$PATH:/var/www/html/vendor/bin
COPY tools/docker/images/php/root /
WORKDIR /var/www/html
RUN apt-get update -yqq \
  && apt-get install -yqq --no-install-recommends \
    libpng-dev \
    mariadb-client \
  && docker-php-ext-install \
    bcmath \
    gd \
    pdo_mysql \
  && rm -fr /var/lib/apt/lists/*

FROM base AS dev
RUN apt-get update -yqq && apt-get install -yqq --no-install-recommends \
    git \
    unzip \
  && rm -fr /var/lib/apt/lists/*
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1
WORKDIR /var/www/html
COPY composer.json .
COPY composer.lock .
RUN composer install
COPY . .

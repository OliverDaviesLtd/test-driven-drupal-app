ARG PHP_VERSION=7.4

FROM php:${PHP_VERSION}-apache AS base
ENV PATH=$PATH:/var/www/html/vendor/bin
COPY tools/docker/images/php/root /
WORKDIR /var/www/html
RUN apt update -yqq \
  && apt install -yqq \
    libpng-dev \
    mariadb-client \
  && docker-php-ext-install \
    bcmath \
    gd \
    pdo_mysql

FROM base AS dev
RUN apt install -yqq \
  git \
  unzip
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1
WORKDIR /var/www/html
COPY composer.json .
COPY composer.lock .
RUN composer install
COPY . .

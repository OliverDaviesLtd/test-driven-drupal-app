FROM php:7.4-fpm-alpine AS base
ENV PATH=$PATH:/app/vendor/bin
WORKDIR /app
RUN apk add --no-cache \
    libpng-dev \
    mariadb-client \
  && docker-php-ext-install \
    bcmath \
    gd \
    pdo_mysql
RUN mkdir -p web/sites/default/files \
  && chown -R www-data:www-data web/sites/default/files

FROM base AS dev
RUN apk add --no-cache \
  git \
  unzip
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_MEMORY_LIMIT=-1
COPY composer.json .
COPY composer.lock .
RUN composer install
COPY . .

FROM dev AS test
RUN mkdir -p web/sites/simpletest \
  && chown -R www-data: web/sites/simpletest
USER www-data
RUN phpunit

FROM nginx:1-alpine AS nginx
WORKDIR /app
COPY tools/docker/images/nginx/root /
COPY web web

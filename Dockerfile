# Do not edit this file. It is automatically generated by 'build-configs'.

FROM php:8.1-fpm-bullseye AS base

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN which composer && composer -V

ARG DOCKER_UID=1000
ENV DOCKER_UID="${DOCKER_UID}"

WORKDIR /app

RUN adduser --disabled-password --uid "${DOCKER_UID}" app \
  && chown app:app -R /app

USER app

ENV PATH="${PATH}:/app/bin:/app/vendor/bin"

COPY --chown=app:app composer.* ./

################################################################################

FROM base AS build

USER root

RUN apt-get update -yqq \
  && apt-get install -yqq --no-install-recommends \
    git libpng-dev libzip-dev mariadb-client unzip

RUN docker-php-ext-install gd pdo_mysql zip

COPY --chown=app:app phpunit.xml* ./



USER app

RUN composer validate --strict
RUN composer install --quiet --no-progress

COPY --chown=app:app tools/docker/images/php/root /

ENTRYPOINT ["/usr/local/bin/docker-entrypoint-php"]
CMD ["php-fpm"]



################################################################################

FROM caddy:2 as web

WORKDIR /app

COPY tools/docker/images/web/root /


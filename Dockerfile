#
# JBZoo Toolbox - Csv-Blueprint.
#
# This file is part of the JBZoo Toolbox project.
# For the full copyright and license information, please view the LICENSE
# file that was distributed with this source code.
#
# @license    MIT
# @copyright  Copyright (C) JBZoo.com, All rights reserved.
# @see        https://github.com/JBZoo/Csv-Blueprint
#

FROM alpine:3.9 AS preparatory
RUN apk add --no-cache make git
WORKDIR /tmp
COPY . /tmp
RUN make build-version

########################################################################################
FROM php:8.3-cli-alpine

# Install PHP extensions
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions opcache @composer

# Install application
WORKDIR /app
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY . /app
COPY --from=preparatory /tmp/.version /app/.version
RUN composer install --no-dev --classmap-authoritative --no-progress \
    && rm -rf ./.git \
    && composer clear-cache \
    && chmod +x ./csv-blueprint \
    && chmod +x ./docker/entrypoint.sh

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./docker/php.ini /usr/local/etc/php/conf.d/docker-z99-php.ini

# Warmup caches
RUN OPCACHE_COMPILER=1 php ./docker/build-preloader.php \
    && php ./docker/preload.php \
    && du -sh /app/docker
#    && echo "opcache.preload=/app/docker/preload.php" >> /usr/local/etc/php/conf.d/docker-z99-php.ini


# Quick test
RUN time ./csv-blueprint -V

ENTRYPOINT ["/app/csv-blueprint"]

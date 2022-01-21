FROM php:8.1.1-fpm-alpine3.15

RUN echo http://dl-cdn.alpinelinux.org/alpine/edge/testing >> /etc/apk/repositories

RUN apk add --update --no-cache \
    bash \
    make \
    autoconf \
    alpine-sdk

RUN docker-php-ext-install bcmath

RUN curl -sS https://getcomposer.org/installer | tee composer-setup.php \
    && php composer-setup.php && rm composer-setup.php* \
    && chmod +x composer.phar && mv composer.phar /usr/bin/composer

COPY symfony.ini /etc/php81/conf.d/
COPY symfony.ini /etc/php81/cli/conf.d/

COPY symfony.pool.conf /etc/php81/php-fpm.d/

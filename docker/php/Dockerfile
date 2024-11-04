FROM php:8.2-fpm

RUN apt update \
    && apt install -y git zip unzip curl libpq-dev \
	&& rm -rf /var/lib/apt/lists/* \
	&& docker-php-ext-install pgsql pdo_pgsql pdo

COPY ./docker/php/composer/install.sh /build/composer/install.sh

RUN sh /build/composer/install.sh

RUN mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/app

COPY composer.lock composer.json ./

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-scripts --no-autoloader --no-interaction


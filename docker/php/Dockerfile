FROM php:7.3-fpm-alpine

RUN apk --no-cache add \
    mariadb-client \
    icu-dev

RUN docker-php-ext-configure intl

RUN docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql

RUN docker-php-ext-enable intl

RUN echo "date.timezone=\"Europe/Berlin\"" >> /usr/local/etc/php/conf.d/timezone.ini

RUN mkdir -p /usr/share/www/chal && adduser -D -u 1000 user

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/bin/composer

USER user

RUN composer global require hirak/prestissimo

WORKDIR /usr/share/www/chal
ENV PATH "$PATH:vendor/bin:bin"

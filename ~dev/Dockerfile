FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        git \
        curl \
        wget \
#    && docker-php-ext-install pgsql \
#    && docker-php-ext-configure pgsql \

#ADD ./php.ini /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data

WORKDIR /var/www

#USER "${USER_ID}:${GROUP_ID}"

CMD ["php-fpm"]
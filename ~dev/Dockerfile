FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        git \
        curl \
        gnupg \
        wget \
        unzip \
        protobuf-compiler \
        libpq-dev \
        libzip-dev \
        libgrpc-dev \
        libcurl4-openssl-dev \
        yarn

RUN docker-php-ext-install pgsql && docker-php-ext-configure pgsql && \
    docker-php-ext-install pdo_pgsql && docker-php-ext-configure pdo_pgsql && \
    docker-php-ext-install curl && docker-php-ext-configure curl && \
    docker-php-ext-install zip && docker-php-ext-configure zip
#    docker-php-ext-install grpc && docker-php-ext-configure grpc

ADD ./php/php.ini /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

#composer require symfony/security-bundle --ignore-platform-reqs

#RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

WORKDIR /var/www

#USER "${USER_ID}:${GROUP_ID}"

CMD ["php-fpm"]
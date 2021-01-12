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
        libcurl4-openssl-dev \
        make

RUN docker-php-ext-install pgsql && docker-php-ext-configure pgsql && \
    docker-php-ext-install pdo_pgsql && docker-php-ext-configure pdo_pgsql && \
    docker-php-ext-install curl && docker-php-ext-configure curl && \
    docker-php-ext-install zip && docker-php-ext-configure zip

ADD ./php/php.ini /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && \
    apt-get install -y yarn

WORKDIR /var/www

ENTRYPOINT ["make", "-f", "~dev/Makefile"]
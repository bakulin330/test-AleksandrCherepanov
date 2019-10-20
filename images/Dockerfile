FROM php:7.2.8
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && \
    apt-get install -y apt-utils ssh zip libzip-dev git-core --no-install-recommends && \
    pecl install zip && \
    docker-php-ext-enable zip && \
    curl -sS https://getcomposer.org/installer -o composer-setup.php &&  \
    php composer-setup.php --install-dir=/usr/local/bin/ --filename=composer

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
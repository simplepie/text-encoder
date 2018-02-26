FROM php:7.2.2-cli-alpine3.7

ENV BUILD_DEPS alpine-sdk curl-dev icu-dev libxml2-dev
ENV PERSISTENT_DEPS curl icu make
ENV INSTALL_EXTENSIONS curl intl json opcache mbstring xml zip

# Install Packages
RUN apk upgrade --update && \
    apk add --virtual .build-deps $BUILD_DEPS && \
    apk add --virtual .persistent-deps $PERSISTENT_DEPS && \
    docker-php-ext-install $INSTALL_EXTENSIONS && \
    apk del .build-deps

# Copy PHP Config
COPY build/tests/php.ini /usr/local/etc/php/php.ini

# Set To non root user
USER www-data

WORKDIR /var/text-encoder

ENTRYPOINT ["make", "test"]

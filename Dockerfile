################################################################################
# base image
################################################################################

FROM debian:11.0-slim

################################################################################
# build args & environment vars
################################################################################

ARG DEBIAN_FRONTEND=noninteractive
ARG APP_PHP_VER="8.0"
ARG APP_COMPOSER_VER="2.1.4"

ENV TERM=xterm
ENV PATH=${PATH}:/app/vendor/bin

################################################################################
# source code
################################################################################

COPY . /app
WORKDIR /app

################################################################################
# dependencies
################################################################################

RUN apt-get update && apt-get install -y -qq --no-install-recommends \
    ca-certificates \
    lsb-release \
    curl \
    git \
    unzip \
    python3-pip; \
    \
################################################################################
# python packages
################################################################################
    \
    pip3 install lastversion; \
    \
################################################################################
# php & composer
################################################################################
    \
    curl https://packages.sury.org/php/apt.gpg --output /etc/apt/trusted.gpg.d/php.gpg; \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list; \
    apt-get update && apt-get install -y -qq --no-install-recommends \
    php${APP_PHP_VER}-cli \
    php${APP_PHP_VER}-curl \
    php${APP_PHP_VER}-mbstring \
    php${APP_PHP_VER}-dom; \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --version=${APP_COMPOSER_VER} --filename=composer; \
    \
################################################################################
# apt-cache
################################################################################
    \
    apt-get -y autoremove && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*; \
    \
################################################################################
# composer install
################################################################################
    \
    composer install --no-dev;

ENTRYPOINT ["php", "/app/nevermind.php"]

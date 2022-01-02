FROM php:7.4-fpm

RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
RUN apt-get update \
    && apt-get install -y \
    git \
    zip \
    unzip \
    vim \
    nodejs \
    npm \
    libpq-dev \
    libgtk2.0-0 \
    libgtk-3-0 \
    libgbm-dev \
    libnotify-dev \
    libgconf-2-4 \
    libnss3 \
    libxss1 \
    libasound2 \
    libxtst6 \
    xauth \
    xvfb \
    locales \
    locales-all \
    && apt-get remove fonts-vlgothic \
    && apt-get install -y fonts-vlgothic \
    && locale-gen ja_JP.UTF-8 \
    && docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql
ENV LANG ja_JP.UTF-8
ENV LC_CTYPE ja_JP.UTF-8
RUN localedef -f UTF-8 -i ja_JP ja_JP.utf8

WORKDIR /var/www/html

COPY package* /var/www/html
RUN npm install
COPY . .
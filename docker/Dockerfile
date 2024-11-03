FROM php:8.2-fpm

ARG USERNAME=docker
ARG USER_UID=1000
ARG USER_GID=1000

RUN apt-get update && apt-get install -y libzip-dev zip unzip git libpng-dev libonig-dev libxml2-dev

RUN docker-php-ext-install zip gd pdo pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN groupadd --gid $USER_GID $USERNAME
RUN useradd --uid $USER_UID --gid $USER_GID -m $USERNAME

USER $USERNAME

WORKDIR /var/www/html

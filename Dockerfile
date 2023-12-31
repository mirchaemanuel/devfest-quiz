# syntax=docker/dockerfile:1
ARG BASE_PHP_IMAGE=ghcr.io/mirchaemanuel/devfest-quiz-php
ARG BASE_PHP_IMAGE_VERSION=latest

FROM node:18-alpine AS node
ARG NODE_USER="node"
ARG APPROOT="/app"
WORKDIR $APPROOT
COPY --chown=${NODE_USER}:${NODE_USER} . .
RUN chown --recursive ${NODE_USER}:${NODE_USER} ${APPROOT}
USER ${NODE_USER}
RUN npm ci \
&& npm run build \
&& rm -rf node_modules

FROM ${BASE_PHP_IMAGE}:${BASE_PHP_IMAGE_VERSION} as app

ARG USERNAME=www-data
ARG APPROOT="/app"
ENV APACHE_DOCUMENT_ROOT ${APPROOT}/public

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN <<EOF cat >> $PHP_INI_DIR/conf.d/99-config.ini
upload_max_filesize=1G
post_max_size=1G
max_execution_time=300
max_input_time=300
memory_limit=1G
max_input_vars=10000
EOF


RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR $APPROOT

COPY --chown=${USERNAME}:${USERNAME} . .
COPY --chown=${USERNAME}:${USERNAME} --from=node ${APACHE_DOCUMENT_ROOT}/build ${APACHE_DOCUMENT_ROOT}/build
RUN chown --recursive ${USERNAME}:${USERNAME} ${APPROOT}

USER $USERNAME
RUN composer install --no-dev --no-interaction --no-progress --optimize-autoloader
USER root

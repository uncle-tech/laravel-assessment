FROM php:7.4-apache

RUN apt-get update && apt-get install -y --fix-missing \
    apt-utils \
    gnupg \
    zlib1g-dev \
    libzip-dev \
    unzip \
    zip

COPY api.conf /etc/apache2/sites-available
RUN ln -s /etc/apache2/sites-available/api.conf /etc/apache2/sites-enabled/api.conf && \
    rm /etc/apache2/sites-enabled/000-default.conf

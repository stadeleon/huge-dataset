FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    curl \
    && docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

RUN pecl install xdebug && docker-php-ext-enable xdebug

COPY conf.d/custom.ini /usr/local/etc/php/conf.d/custom.ini
COPY conf.d/xdebug.ini /usr/local/etc/php/conf.d/

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]


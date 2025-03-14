#!/bin/sh

if [ -z "$(ls -A /var/www/app)" ]; then
    echo "Dir /var/www/app is empty. Downloading Symfony skeleton..."
    composer create-project symfony/skeleton:"^6.4" /var/www/app
    composer require symfony/webapp-pack
    composer require ramsey/uuid-doctrine
    composer require nelmio/api-doc-bundle

#    php bin/console doctrine:migrations:migrate
#    php bin/console doctrine:migrations:migrate --env=test

fi

exec php-fpm

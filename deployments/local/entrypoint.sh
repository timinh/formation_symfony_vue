#!/usr/bin/env sh

composer install

# migrations
php bin/console doctrine:migrations:migrate --no-interaction

exec "$@"
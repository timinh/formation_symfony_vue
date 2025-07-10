#!/usr/bin/env sh

composer install --no-interaction --optimize-autoloader

# migrations
php bin/console doctrine:migrations:migrate --no-interaction

php bin/console lexik:jwt:generate-keypair --overwrite --no-interaction

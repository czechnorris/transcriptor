#!/usr/bin/env bash
git pull
export SYMFONY_ENV=prod
php composer.phar install --no-dev --optimize-autoloader
chown -R www-data:www-data app/logs/ app/cache/
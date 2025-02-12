##!/usr/bin/env bash
#echo "Running composer"
#composer install --no-dev --working-dir=/var/www/html
#
#echo "Caching config..."
#php artisan config:cache
#
#echo "Caching routes..."
#php artisan route:cache
#
#echo "Running migrations..."
#php artisan migrate --force
#
#echo "Running install"
#cp -n .env.example .env
#php artisan key:gen --ansi
#touch database/database.sqlite
#php artisan db:seed
#npm ci
#npm run build

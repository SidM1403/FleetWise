#!/bin/bash
set -e

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo "APP_KEY is not set. Generating one..."
    php artisan key:generate --force
fi

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Seed the database
echo "Seeding database..."
php artisan db:seed --force

# Clear and cache configuration, routes, and views
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Execute the main container command (CMD)
exec "$@"

#!/bin/bash
set -e

echo "🚀 Starting deployment process..."

echo "🚧 Putting the application into maintenance mode..."
php artisan down || true

echo "📥 Pulling latest code from Git..."
git pull origin main

echo "📦 Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Notice: The npm install and npm run build commands are completely gone

echo "🗄️ Running database migrations..."
php artisan migrate --force

echo "🧹 Optimizing Laravel caches..."
php artisan optimize

echo "✅ Bringing the application back online..."
php artisan up

echo "🎉 Deployment complete!"

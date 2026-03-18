#!/bin/bash

# Exit immediately if any command fails
set -e

echo "🚀 Starting deployment process..."

# 1. Turn on maintenance mode (shows a 503 Service Unavailable page to users)
echo "🚧 Putting the application into maintenance mode..."
php artisan down || true

# 2. Pull the latest changes from your repository (update 'main' if your branch is named differently)
echo "📥 Pulling latest code from Git..."
git pull origin main

# 3. Install PHP dependencies securely for production
echo "📦 Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 4. Install Node dependencies
echo "📦 Installing Node dependencies..."
npm install

# 5. Compile frontend Tailwind/Vite assets
echo "🏗️ Building frontend assets..."
npm run build

# 6. Run database migrations without asking for confirmation
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 7. Clear old caches and build new highly optimized ones
echo "🧹 Optimizing Laravel caches..."
php artisan optimize

# 8. Turn off maintenance mode
echo "✅ Bringing the application back online..."
php artisan up

echo "🎉 Deployment complete!"

cd /home/ploi/yensab.com
git pull origin master
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
npm install
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
npm run prod
echo "" | sudo -S service php8.2-fpm reload

echo "🚀 Application deployed!"
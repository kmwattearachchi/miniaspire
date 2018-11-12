## Initial setup
Update DB details in .env 

Update the APP_URL in .env

composer update

## Permission Commands

sudo chmod -R 777 storage/

sudo chmod -R 777 bootstrap/cache/

## Artisan Commands

php artisan config:clear

php artisan cache:clear

php artisan view:clear

php artisan module:optimize

php artisan optimize

composer dump-autoload

php artisan migrate

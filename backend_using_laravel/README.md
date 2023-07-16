### Run command in terminal------

1.composer install
2.composer require intervention/image

### For storing images------------

php artisan storage:link

## Add line in config/app.php/providers

Intervention\Image\ImageServiceProvider::class,

## Add line in config/app.php/aliases

1.'Image' => Intervention\Image\Facades\Image::class,

## Run command in terminal------

php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravelRecent"

## for migrate products data

php artisan migrate

## For user token register run in terminal ----

composer require laravel/sanctum
## If you do not have key

php artisan key:generate
## set firebase

composer require firebase/php-jwt

## Sending Command

php artisan make:command TaskReminderCommand

## Register schedule in app/Console/Kernel.php

$schedule->command('task:reminder')->daily();

## Run command for reminder

php artisan task:reminder

## NCHL
Connect IPS payment gateway package.
[![Latest Stable Version](https://poser.pugx.org/yubarajshrestha/nchl/v/stable)](https://packagist.org/packages/yubarajshrestha/nchl)
[![Total Downloads](https://poser.pugx.org/yubarajshrestha/nchl/downloads)](https://packagist.org/packages/yubarajshrestha/nchl)
[![Latest Unstable Version](https://poser.pugx.org/yubarajshrestha/nchl/v/unstable)](https://packagist.org/packages/yubarajshrestha/nchl)
[![License](https://poser.pugx.org/yubarajshrestha/nchl/license)](https://packagist.org/packages/yubarajshrestha/nchl)

### Installation
Require this package with composer.
```shell
composer install yubarajshrestha/nchl
```
Publish configurations and other required helpers.
```shell 
php artisan vendor publish --tag=nchl
```
Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

### Laravel 5.5+:
If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php
```php
YubarajShrestha\NCHL\NchlServiceProvider::class,
```
If you want to use the facade to log messages, add this to your facades in app.php:
```php
'NCHL' => YubarajShrestha\NCHL\Facades\NchlFacade::class,
```
#### Copy the package config to your local config with the publish command:
```shell
php artisan vendor:publish --provider="YubarajShrestha\NCHL\NchlServiceProvider"
```
#### Copy the environment variables and setup as per required in .env:
```shell
NCHL_MERCHANT_ID=
NCHL_APP_ID=
NCHL_APP_NAME=
NCHL_APP_PASSWORD=
NCHL_GATEWAY=
NCHL_VALIDATION_URL=
NCHL_TRANSACTION_DETAIL_URL=
```

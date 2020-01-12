## NCHL
Connect IPS payment gateway package.

[![Latest Stable Version](https://poser.pugx.org/yubarajshrestha/nchl/v/stable)](https://packagist.org/packages/yubarajshrestha/nchl)
[![Total Downloads](https://poser.pugx.org/yubarajshrestha/nchl/downloads)](https://packagist.org/packages/yubarajshrestha/nchl)

[![License](https://poser.pugx.org/yubarajshrestha/nchl/license)](https://packagist.org/packages/yubarajshrestha/nchl)
![Build](https://travis-ci.com/yubarajshrestha/nchl.svg?branch=master)
[![StyleCI](https://github.styleci.io/repos/230768636/shield?branch=master)](https://github.styleci.io/repos/230768636)
[![All Contributors](https://img.shields.io/badge/all_contributors-2-orange.svg?style=flat-square)](#contributors-)

### Installation
Require this package with composer.
```shell
composer require yubarajshrestha/nchl
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
### Copy the package config to your local config with the publish command:
```shell
php artisan vendor:publish --provider="YubarajShrestha\NCHL\NchlServiceProvider"
```
### Copy the environment variables and setup as per required in .env:
```shell
NCHL_MERCHANT_ID=
NCHL_APP_ID=
NCHL_APP_NAME=
NCHL_APP_PASSWORD=
NCHL_GATEWAY=
NCHL_VALIDATION_URL=
NCHL_TRANSACTION_DETAIL_URL=
```
### Contributors
<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="https://bindukarki.com.np"><img src="https://avatars3.githubusercontent.com/u/20794268?s=460&v=4" width="100px;" alt=""/><br /><sub><b>Bindu Karki</b></sub></a></td>
    <td align="center"><a href="https://yubarajshrestha.com.np"><img src="https://avatars0.githubusercontent.com/u/7955362?s=460&v=4" width="100px;" alt=""/><br /><sub><b>Yubaraj Shrestha</b></sub></a></td>
  </tr>
</table>

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

### License

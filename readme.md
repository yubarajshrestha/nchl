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

### Basic Usage
A `NCHL` is Service Class and can be instanciated like this:

```php
// In Controller
$nchl = NCHL::__init([
    "txn_id" => '3',
    "txn_date" => '1-10-2020',
    "txn_amount" => '500',
    "reference_id" => 'REF-001',
    "remarks" => 'RMKS-001',
    "particulars" => 'PART-001',
]);
```

And then in view you will create a form to start payment, which redirects you to `Connect IPS`.

```html
// In View
<form action="{{ $nchl->core->gatewayUrl() }}" method="post">
    <label>MERCHANT ID</label>
    <input type="text" name="MERCHANTID" id="MERCHANTID" value="{{ $nchl->core->getMerchantId() }}"/>
    <label>APP ID</label>
    <input type="text" name="APPID" id="APPID" value="{{ $nchl->core->getAppId() }}"/>
    <label>APP NAME</label>
    <input type="text" name="APPNAME" id="APPNAME" value="{{ $nchl->core->getAppName() }}"/>
    <label>TXN ID</label>
    <input type="text" name="TXNID" id="TXNID" value="{{ $nchl->core->getTxnId() }}"/>
    <label>TXN DATE</label>
    <input type="text" name="TXNDATE" id="TXNDATE" value="{{ $nchl->core->getTxnDate() }}"/>
    <label>TXN CRNCY</label>
    <input type="text" name="TXNCRNCY" id="TXNCRNCY" value="{{ $nchl->core->getCurrency() }}"/>
    <label>TXN AMT</label>
    <input type="text" name="TXNAMT" id="TXNAMT" value="{{ $nchl->core->getTxnAmount() }}"/>
    <label>REFERENCE ID</label>
    <input type="text" name="REFERENCEID" id="REFERENCEID" value="{{ $nchl->core->getReferenceId() }}"/>
    <label>REMARKS</label>
    <input type="text" name="REMARKS" id="REMARKS" value="{{ $nchl->core->getRemarks() }}"/>
    <label>PARTICULARS</label>
    <input type="text" name="PARTICULARS" id="PARTICULARS" value="{{ $nchl->core->getParticulars() }}"/>
    <label>TOKEN</label>
    <input type="text" name="TOKEN" id="TOKEN" value="{{ $nchl->core->token() }}"/>
    <input type="submit" value="Submit">
</form>
```

After success or failure payment it will redirect you to the redirect url that you've provided to `Connect IPS`.

### Validating Payment and retrieving Payment Details
Re-instantiate the NCHL serivce class same like before.
```php
// In Controller
$nchl = NCHL::__init([
    "txn_id" => '3',
    "txn_date" => '1-10-2020',
    "txn_amount" => '500',
    "reference_id" => 'REF-001',
    "remarks" => 'RMKS-001',
    "particulars" => 'PART-001',
]);

/** Validating Payment **/
$response = $nchl->paymentValidate();

/** Retrieving payment details **/
$response = $nchl->paymentDetails();

```

Well that's it. Enjoy

### Contributors
<table>
  <tr>
    <td align="center"><a href="https://bindukarki.com.np"><img src="https://avatars3.githubusercontent.com/u/20794268?s=460&v=4" width="100px;" alt=""/><br /><sub><b>Bindu Karki</b></sub></a></td>
    <td align="center"><a href="https://yubarajshrestha.com.np"><img src="https://avatars0.githubusercontent.com/u/7955362?s=460&v=4" width="100px;" alt=""/><br /><sub><b>Yubaraj Shrestha</b></sub></a></td>
  </tr>
</table>

### License

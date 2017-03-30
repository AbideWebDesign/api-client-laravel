![Civil Services Logo](https://cdn.civil.services/common/github-logo.png "Civil Services Logo")

__Civil Services__ is a collection of tools that make it possible for citizens to be a part of what is happening in their Local, State & Federal Governments.


API Client for Laravel 5
===

[![Latest Version on Packagist](https://img.shields.io/packagist/v/civilservices/api-client-laravel.svg?style=flat)](https://packagist.org/packages/civilservices/api-client-laravel) [![Total Downloads](https://img.shields.io/packagist/dt/civilservices/api-client-laravel.svg?style=flat-square)](https://packagist.org/packages/civilservices/api-client-laravel) [![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](https://raw.githubusercontent.com/CivilServiceUSA/api-client-laravel/master/LICENSE)  [![GitHub contributors](https://img.shields.io/github/contributors/CivilServiceUSA/api-client-laravel.svg)](https://github.com/CivilServiceUSA/api-client-laravel/graphs/contributors)

Overview
---

This is an API Client for our Civil Services API.  Please see our __[API Documentation](https://api.civil.services/guide/)__ for details on what options are available for Each Endpoint.

Installation
---

### Step 1: Install Through Composer

Our Service Provider can be installed via [Composer](http://getcomposer.org) by either installing through composer:

```bash
composer require civilservices/api-client-laravel
```

or requiring the `civilservices/api-client-laravel` package in your project's `composer.json`.

```json
{
    "require": {
        "civilservices/api-client-laravel": "~1.0"
    }
}
```

Then run a composer update:

```bash
composer update
```

### Step 2: Add the Service Provider

Add the service provider in `app/config/app.php`

```php
'providers' => array(
    // ...
    CivilServices\Api\ApiServiceProvider::class,
)
```

### Step 3: Add the Facade

Add the alias in `app/config/app.php`

```php
'aliases' => [
    // ...
    'CivilServices' => CivilServices\Api\Facades\CivilServices::class,
];
```


Configuration
---

By default, the package uses the following environment variables to auto-configure the plugin without modification:
```
CIVIL_SERVICES_API_BASE
CIVIL_SERVICES_API_VERSION
CIVIL_SERVICES_API_KEY
CIVIL_SERVICES_CACHE_EXPIRE
```

To customize the configuration file, publish the package configuration using Artisan.

```sh
php artisan vendor:publish --provider="CivilServices\Api\ApiServiceProvider"
```

Update your settings in the generated `app/config/civilservices.php` configuration file.

```php
return [
    'api_base' => env('CIVIL_SERVICES_API_BASE', 'https://api.civil.services'),
    'api_key' => env('CIVIL_SERVICES_API_KEY', 'YOUR_API_KEY'),
    'api_version' => env('CIVIL_SERVICES_API_VERSION', 'v1'),
    'cache_expire' => env('CIVIL_SERVICES_CACHE_EXPIRE', 3600),
];
```

If you need an API Key, you can request one here:  https://api.civil.services


Examples & API Doc Links
---

#### [City Council](https://api.civil.services/guide/#/reference/city-council-endpoints)

```php
use CivilServices;

// Get City Council for the city and state of New York, NY
$city_council = CivilServices::getCityCouncil('NY', 'New York');

// Search all City Council's in the USA for Female African American's
$city_council = CivilServices::searchCityCouncil([
    'gender' => 'female', 
    'ethnicity' => 'african-american'
]);

```

#### [Geolocation](https://api.civil.services/guide/#/reference/geolocation-endpoints)

```php
 use CivilServices;
 
// Get Geolocation Data for Zip Code 10004
 $zipcode = CivilServices::getGeolocationZipcode('10004');
 
// Get Geolocation Data for IP Address 97.96.74.114
$ipaddress = CivilServices::getGeolocationIP('97.96.74.114');

// Search all Geolocation Data in the USA with a minimum population of 1,000,000 people
$geolocation = CivilServices::searchGeolocation([
    'minPopulation' => 1000000
]);
```

#### [Government](https://api.civil.services/guide/#/reference/government-endpoints)

```php
use CivilServices;

// Get Government Data for Specific GPS Location
$geolocation = CivilServices::searchGovernment([
    'latitude' => 27.782805
    'longitude' => -82.63314
]);
```

#### [House](https://api.civil.services/guide/#/reference/house-endpoints)

```php
use CivilServices;

// Search all House of Representatives's for Female African American's
$house = CivilServices::searchHouse([
    'gender' => 'female',
    'ethnicity' => 'african-american'
]);
```

#### [Legislators](https://api.civil.services/guide/#/reference/legislator-endpoints)

```php
use CivilServices;

// Get Legislators for Specific GPS Location
$legislators = CivilServices::searchLegislators([
    'latitude' => 27.782805
    'longitude' => -82.63314
]);
```

#### [Senate](https://api.civil.services/guide/#/reference/senate-endpoints)

```php
use CivilServices;

// Search all Senators's for Female African American's
$senate = CivilServices::searchSenate([
    'gender' => 'female',
    'ethnicity' => 'african-american'
]);
```

#### [State](https://api.civil.services/guide/#/reference/state-endpoints)

```php
use CivilServices;

// Get information about New York
$state = CivilServices::getState('NY');

// Search all US States with a minimum population of 1,000,000 people
$state = CivilServices::searchStates([
    'minPopulation' => 1000000
]);
```


Testing
---

Run the tests with:

```bash
./vendor/bin/phpunit
```
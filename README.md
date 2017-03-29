![Civil Services Logo](https://cdn.civil.services/common/github-logo.png "Civil Services Logo")

__Civil Services__ is a collection of tools that make it possible for citizens to be a part of what is happening in their Local, State & Federal Governments.


API Client for Laravel 5
===

[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](https://raw.githubusercontent.com/CivilServiceUSA/api-client-laravel/master/LICENSE)  [![GitHub contributors](https://img.shields.io/github/contributors/CivilServiceUSA/api-client-laravel.svg)](https://github.com/CivilServiceUSA/api-client-laravel/graphs/contributors)


Installation
---

Our Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the `civilservices/api` package in your project's `composer.json`.

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

### Laravel App

In Laravel find the `providers` key in your `config/app.php` and register our Provider.

```php
'providers' => array(
    // ...
    CivilServices\Api\ApiServiceProvider::class,
)
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
php artisan vendor:publish
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
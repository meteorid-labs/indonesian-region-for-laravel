# Laravel Region

[![Region tests](https://github.com/meteorid-labs/laravel-indonesian-region/actions/workflows/tests.yml/badge.svg)](https://github.com/meteorid-labs/laravel-indonesian-region/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/meteor/indonesian-region/v/stable)](https://packagist.org/packages/meteor/indonesian-region)
[![Total Downloads](https://poser.pugx.org/meteor/indonesian-region/downloads)](https://packagist.org/packages/meteor/indonesian-region)
[![License](https://poser.pugx.org/meteor/indonesian-region/license)](https://packagist.org/packages/meteor/indonesian-region)

Meteor Region is a package that provides a simple way to manage regions in your application. It is used data from [cahyadsn wilayah](https://github.com/cahyadsn/wilayah) package.

## Installation

You can install the package via composer:

```bash
composer require meteor/indonesian-region
```

## Publishing the config file

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Meteor\Region\RegionServiceProvider" --tag="meteor.region.config"
```

## Usage

Currently, this package only provides data from year 2022

```bash
php artisan region:import --year=2022
```

## License

Meteor Region is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

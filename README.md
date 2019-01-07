Laravel VAT
================

<a href="https://travis-ci.org/dannyvankooten/laravel-vat"><img src="https://img.shields.io/travis/dannyvankooten/laravel-vat/master.svg?style=flat-square" alt="Build Status"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></img></a>

laravel-vat is a Laravel package that contains the Laravel-related wiring code for [vat.php](https://github.com/dannyvankooten/vat.php), helping you deal with VAT for businesses based in Europe.

- Fetch (historical) VAT rates for any European member state using [jsonvat.com](https://github.com/adamcooke/vat-rates)
- Validate VAT numbers (by format, [existence](http://ec.europa.eu/taxation_customs/vies/) or both)
- Validate ISO-3316 alpha-2 country codes
- Determine whether a country is part of the EU
- Geolocate IP addresses

## Installation

You can install this package via Composer:

```bash
$ composer require dannyvankooten/laravel-vat
```

The package will automatically register itself.


## Usage

If you registered the facades then using an instance of the classes is as easy as this:

```php
use DvK\Laravel\Vat\Facades\Rates;
use DvK\Laravel\Vat\Facades\Validator;
use DvK\Laravel\Vat\Facades\Countries;

Rates::country( 'NL' ); // 21
Rates::country( 'NL', 'reduced' ); // 6
Rates::all(); // array in country code => rates format

Validator::validate('NL50123'); // false
Validator::validateFormat('NL203458239B01'); // true (checks format)
Validator::validateExistence('NL203458239B01') // false (checks existence)
Validator::validate('NL203458239B01'); // false (checks format + existence)

Countries::all(); // array of country codes + names
Countries::name('NL') // Netherlands
Countries::europe(); // array of EU country codes + names
Countries::inEurope('NL'); // true
Countries::ip('8.8.8.8'); // US
```

By default, VAT rates are cached for 24 hours using the default cache driver.

## License

laravel-vat is licensed under [The MIT License (MIT)](LICENSE).

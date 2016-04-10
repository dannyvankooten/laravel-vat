Laravel VAT
================

<a href="https://travis-ci.org/dannyvankooten/laravel-vat"><img src="https://img.shields.io/travis/dannyvankooten/laravel-vat/master.svg?style=flat-square" alt="Build Status"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></img></a>

Laravel VAT is a simple Laravel library which helps you in dealing with European VAT rules. It helps you...

- Grab up-to-date VAT rates for any European member state
- Validate VAT numbers (by format or existence)
- Work with ISO 3166-1 alpha-2 country codes and determine whether they're part of the EU.
- Geolocate IP addresses

The library uses jsonvat.com to obtain its data for the VAT rates. Full details can be seen [here](https://github.com/adamcooke/vat-rates).
For VAT number validation, this uses the [VIES VAT number validation](http://ec.europa.eu/taxation_customs/vies/).

## Installation

[PHP](https://php.net) 5.6+ is required. For VAT number existence checking, the PHP SOAP extension is required as well.

To get the latest version of Laravel VAT, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require dannyvankooten/laravel-vat dev-master
```

Once Laravel VAT is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `'DvK\Laravel\Vat\VatServiceProvider'`

You can register facades in the `aliases` key of your `config/app.php` file if you like.

* `'VatRates' => 'DvK\Laravel\Vat\Facades\Rates'`
* `'VatValidator' => 'DvK\Laravel\Vat\Facades\Validator'`
* `'Countries' => 'DvK\Laravel\Vat\Facades\Countries'`


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

If you'd prefer to use dependency injection, you can easily inject the class like this.


```php
use DvK\Laravel\Vat\Facades\Rates;

class Foo
{
    protected $rates;

    public function __construct(Rates $rates)
    {
        $this->rates = $rates;
    }

    public function bar()
    {
        return $this->rates->country('NL');
    }
}
```

By default, VAT rates are cached for 24 hours using the default cache driver.

## License

Laravel VAT is licensed under [The MIT License (MIT)](LICENSE).

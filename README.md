Laravel VAT
================

<a href="https://travis-ci.org/dannyvankooten/laravel-vat"><img src="https://img.shields.io/travis/dannyvankooten/laravel-vat/master.svg?style=flat-square" alt="Build Status"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></img></a>

> See [ibericode/vat-bundle](https://github.com/ibericode/vat-bundle) for a Symfony version of this package.

laravel-vat is a package that contains the Laravel related wiring code for [ibericode/vat](https://github.com/ibericode/vat/tree/1.2.1), helping you deal with VAT legislation for businesses based in the EU.

- Fetch (historical) VAT rates for any European member state using [jsonvat.com](https://github.com/adamcooke/vat-rates)
- Validate VAT numbers (by format, [existence](http://ec.europa.eu/taxation_customs/vies/) or both)
- Validate ISO-3316 alpha-2 country codes
- Determine whether a country is part of the EU
- Geolocate IP addresses

## Installation

You can install this package via [Composer](https://getcomposer.org/):

```bash
composer require dannyvankooten/laravel-vat
```

The package will automatically register itself.


## Usage

Check out the [ibericode/vat README](https://github.com/ibericode/vat/tree/1.2.1) for general usage of this package.


#### Facades

You can use facades to retrieve an instance of the classes provided by ibericode/vat.

```php
use DvK\Laravel\Vat\Facades\Rates;
use DvK\Laravel\Vat\Facades\Validator;
use DvK\Laravel\Vat\Facades\Countries;

Rates::country('NL'); // 21
Rates::country('NL', 'reduced'); // 6
Rates::country('NL', 'reduced', new \DateTime('2005-01-01')); // 19
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


#### Validation

The package registers two new validation rules.

**vat_number**

The field under validation must be a valid and existing VAT number.

**country_code**

The field under validation must be a valid ISO-3316 alpha-2 country code.

```php
use Illuminate\Http\Request;

class Controller {

    public function foo(Request $request)
    {
        $request->validate([
            'vat_number_field' => ['vat_number'],
            'country_code_field' => [ 'country_code' ],
        ]);
    }
}
```

Alternatively, you can also use the `Rule` objects directly.

```php
use Illuminate\Http\Request;
use DvK\Laravel\Vat\Rules;

class Controller {

    public function foo(Request $request)
    {
        $request->validate([
            'vat_number_field' => [ new Rules\VatNumber() ],
            'country_code_field' => [ new Rules\Country() ],
        ]);
    }
}
```

## Localization
You can translate the validation error message by [Using Translation Strings As Keys](https://laravel.com/docs/6.x/localization#using-translation-strings-as-keys) for the following strings:

`resources/lang/de.json`
```
{
    "The :attribute must be a valid VAT number.": "Your translation for the VatNumber Rule",
    "The :attribute must be a valid country.": "Your translation for the Country Rule"
}
```

## License

[MIT licensed](LICENSE).

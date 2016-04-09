Laravel VAT
================

Laravel VAT is a small & lightweight Laravel library to grab VAT rates for any EU country and/or to validate VAT numbers.

This uses jsonvat.com to obtain its data for the VAT rates. Full details can be seen [here](https://github.com/adamcooke/vat-rates).

For VAT number validation, this uses the [VIES VAT number validation](http://ec.europa.eu/taxation_customs/vies/) , which requires SOAP.

## Installation

Either [PHP](https://php.net) 5.5+ or [HHVM](http://hhvm.com) 3.6+ are required.

To get the latest version of Laravel VAT, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require dannyvankooten/laravel-vat dev-master
```

Once Laravel VAT is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `'DvK\Laravel\Vat\VatServiceProvider'`

You can register the VatRates facade in the `aliases` key of your `config/app.php` file if you like.

* `'VatRates' => 'DvK\Laravel\Vat\Facades\Rates'`
* `'VatValidator' => 'DvK\Laravel\Vat\Facades\Validator'`

## Usage

If you registered the facade then using an instance of the class is as easy as this.

```php
use DvK\Laravel\Vat\Facades\Rates;

Rates::country( 'NL' ); // 21
Rates::country( 'NL', 'reduced' ); // 6
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

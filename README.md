Laravel VAT Rates
================

Laravel VAT Rates is a small & lightweight Laravel library to grab VAT rates for any EU country.

This uses jsonvat.com to obtain its data. Full details can be seen [here](https://github.com/adamcooke/vat-rates).

## Installation

Either [PHP](https://php.net) 5.5+ or [HHVM](http://hhvm.com) 3.6+ are required.

To get the latest version of Laravel VAT Rates, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require dannyvankooten/vat-rates
```

Once Laravel VAT Rates is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `'DvK\VatRates\VatRatesServiceProvider'`

You can register the VatRates facade in the `aliases` key of your `config/app.php` file if you like.

* `'VatRates' => 'DvK\VatRates\Facades\VatRates'`

## Usage

If you registered the facade then using an instance of the class is as easy as this.

```php
use DvK\VatRates\Facades\VatRates;

VatRates::country( 'NL' ); // 21
VatRates::country( 'NL', 'reduced' ); // 6
```

If you'd prefer to use dependency injection, you can easily inject the class like this.


```php
use DvK\VatRates\VatRates;

class Foo
{
    protected $rates;

    public function __construct(VatRates $rates)
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

Laravel VAT Rates is licensed under [The MIT License (MIT)](LICENSE).

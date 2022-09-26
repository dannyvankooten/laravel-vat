<?php

namespace DvK\Tests\LaravelVat;

use DvK\Laravel\Vat\Facades\Countries as CountriesFacade; 
use DvK\Laravel\Vat\Facades\Rates as RatesFacade; 
use DvK\Laravel\Vat\Facades\Validator as ValidatorFacade; 

use Ibericode\Vat\Countries;
use Ibericode\Vat\Rates;
use Ibericode\Vat\Validator;

use Orchestra\Testbench\TestCase;

class ServiceProviderTest extends TestCase
{
    public function testCountries() 
    {
        self::assertEquals(new Countries(), new CountriesFacade);
    }

    public function testRates() 
    {
        self::assertEquals((new Rates())->getRateForCountry('NL'), RatesFacade::getRateForCountry('NL'));
    }

    public function testValidator() 
    {
        self::assertEquals((new Validator())->validateVatNumberFormat('foobar'), ValidatorFacade::validateVatNumberFormat('foobar'));
    }
}

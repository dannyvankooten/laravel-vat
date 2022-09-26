<?php

namespace DvK\Tests\LaravelVat;

use DvK\Laravel\Vat\Facades\Countries as CountriesFacade; 
use DvK\Laravel\Vat\Facades\Rates as RatesFacade; 
use DvK\Laravel\Vat\Facades\Validator as ValidatorFacade; 

use Ibericode\Vat\Countries;
use Ibericode\Vat\Rates\Rates;
use Ibericode\Vat\Validator;

use Orchestra\Testbench\TestCase;

class ServiceProviderTest extends TestCase
{
    public function testCountries() 
    {
        self::assertEquals((new Countries())->all(), CountriesFacade::all());
    }

    public function testRates() 
    {
        self::assertEquals((new Rates())->all(), RatesFacade::all());
    }

    public function testValidator() 
    {
        self::assertEquals((new Validator())->validateFormat('foobar'), ValidatorFacade::validateFormat('foobar'));
    }
}

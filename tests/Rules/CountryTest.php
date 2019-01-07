<?php

namespace DvK\Tests\LaravelVat\Rules;

use DvK\Laravel\Vat\Rules\Country;
use Orchestra\Testbench\TestCase;

class CountryTest extends TestCase
{
    public function testPasses() 
    {
        $rule = new Country();
        self::assertFalse($rule->passes('countryCode', 'foo'));
        self::assertTrue($rule->passes('countryCode', 'NL'));
    }
}
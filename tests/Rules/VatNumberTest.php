<?php

namespace DvK\Tests\LaravelVat;

use DvK\Laravel\Vat\Rules\VatNumber;
use Orchestra\Testbench\TestCase;

class VatNumberTest extends TestCase
{
    public function testPasses() 
    {
        $rule = new VatNumber();
        self::assertFalse($rule->passes('vat_number', 'foo'));
        self::assertTrue($rule->passes('vat_number', 'IE6388047V'));
    }
}
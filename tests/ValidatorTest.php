<?php

namespace DvK\Tests\Laravel\Vat;

use DvK\Laravel\Vat\Validator;

use PHPUnit_Framework_TestCase;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    public function test_check() {
        // TODO
    }

    public function test_isEuCountry() {
        $validator = new Validator();
        self::assertFalse( $validator->isEuCountry( 'US' ) );
        self::assertTrue( $validator->isEuCountry( 'NL' ) );
    }

}



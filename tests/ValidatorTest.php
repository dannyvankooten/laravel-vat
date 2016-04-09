<?php

namespace DvK\Tests\Laravel\Vat;

use DvK\Laravel\Vat\Validator;

use PHPUnit_Framework_TestCase;

/**
 * Class ValidatorTest
 * @package DvK\Tests\Laravel\Vat
 *
 * TODO: Tests for validateFormat method
 * Todo: Tests for validate method
 */
class ValidatorTest extends PHPUnit_Framework_TestCase
{

    public function test_isEuCountry() {
        $validator = new Validator();
        self::assertFalse( $validator->isEuCountry( 'US' ) );
        self::assertTrue( $validator->isEuCountry( 'NL' ) );
    }

}



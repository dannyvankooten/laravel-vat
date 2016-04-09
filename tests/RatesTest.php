<?php

namespace DvK\Tests\Laravel\Vat;

use DvK\Laravel\Vat\Rates;

use PHPUnit_Framework_TestCase;

/**
 * Class RatesTest
 * @package DvK\Tests\Laravel\Vat
 *
 * TODO: Inject client or response so tests do not hit jsonvat.com
 */
class RatesTest extends PHPUnit_Framework_TestCase
{

    /**
     * @throws \Exception
     */
    public function test_country() {
        $rates = new Rates();

        // Throw exception when supplying non-EU country code
        self::expectException( 'Exception' );
        $rates->country('US');

        // Return numerical VAT rate
       self::assertTrue( is_numeric( $rates->country('NL') ) );
    }
}
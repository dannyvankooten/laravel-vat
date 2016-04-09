<?php
namespace DvK\Laravel\Vat;

use SoapClient;
use Exception;
use SoapFault;

/**
 * Class Validator
 *
 * @package DvK\Laravel\Vat
 */
class Validator {

    /**
     * @const string
     */
    const URL = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    /**
     * @var SoapClient
     */
    protected $client;

    /**
     * Regular expression patterns per country code
     *
     * @var array
     * @link http://ec.europa.eu/taxation_customs/vies/faq.html?locale=lt#item_11
     */
    protected static $patterns = array(
        'AT' => 'U[A-Z\d]{8}',
        'BE' => '0\d{9}',
        'BG' => '\d{9,10}',
        'CY' => '\d{8}[A-Z]',
        'CZ' => '\d{8,10}',
        'DE' => '\d{9}',
        'DK' => '(\d{2} ?){3}\d{2}',
        'EE' => '\d{9}',
        'EL' => '\d{9}',
        'ES' => '[A-Z]\d{7}[A-Z]|\d{8}[A-Z]|[A-Z]\d{8}',
        'FI' => '\d{8}',
        'FR' => '([A-Z]{2}|\d{2})\d{9}',
        'GB' => '\d{9}|\d{12}|(GD|HA)\d{3}',
        'HR' => '\d{11}',
        'HU' => '\d{8}',
        'IE' => '[A-Z\d]{8}|[A-Z\d]{9}',
        'IT' => '\d{11}',
        'LT' => '(\d{9}|\d{12})',
        'LU' => '\d{8}',
        'LV' => '\d{11}',
        'MT' => '\d{8}',
        'NL' => '\d{9}B\d{2}',
        'PL' => '\d{10}',
        'PT' => '\d{9}',
        'RO' => '\d{2,10}',
        'SE' => '\d{12}',
        'SI' => '\d{8}',
        'SK' => '\d{10}'
    );

    /**
     * VatValidator constructor.
     *
     * @param SoapClient $client        (optional)
     */
    public function __construct( $client = null ) {
        $this->client = $client;

        // use SoapClient by default
        if( ! $this->client ) {
            $this->client = new SoapClient( self::URL, [ 'connection_timeout' => 15 ] );
        }
    }

    /**
     * @param string $country
     *
     * @return bool
     */
    public function isEuCountry( $country ) {
        $country = strtoupper( $country );
        $country = $this->fixCountryCode($country);
        return isset( self::$patterns[$country] );
    }

    /**
     * Validate a VAT number format. This does not check whether the VAT number was really issued.
     *
     * @param string $vatNumber
     *
     * @return boolean
     */
    public function validateFormat( $vatNumber ) {
        $country = substr( $vatNumber, 0, 2 );
        $number = substr( $vatNumber, 2 );

        if( ! isset( self::$patterns[$country]) ) {
            return false;
        }

        return preg_match( '/' . self::$patterns[$country] . '$/', $number );
    }

    /**
     * Validates a VAT number using format + existence check.
     *
     * Pass a country code as the second parameter if you want to make sure a number is valid for the given ISO-3166-1-alpha2 country.
     *
     * @param string $vatNumber
     * @param string $countryCode
     * @return boolean
     *
     * @throws Exception
     */
    public function validate( $vatNumber, $countryCode = ''  ) {
        $vatNumber = strtoupper( $vatNumber );
        $countryCode = strtoupper( $countryCode );

        // if country code is omitted, use first two chars of vat number
        if( empty( $countryCode ) ) {
            $countryCode = substr( $vatNumber, 0, 2 );
        } else {
            // otherwise, transform country code to ISO-3166-1-alpha2
            $countryCode = $this->fixCountryCode( $countryCode );
        }

        // strip first two characters of VAT number if it matches the country code
        if( substr( $vatNumber, 0, 2 ) === $countryCode ) {
            $vatNumber = substr( $vatNumber, 2 );
        }

        // check VAT number format
        if( ! $this->validateFormat( $countryCode . $vatNumber ) ) {
            return false;
        }

        // call VIES VAT Soap API
        try {
            $response = $this->client->checkVat(
                array(
                    'countryCode' => $countryCode,
                    'vatNumber' => $vatNumber
                )
            );
        } catch( SoapFault $e ) {
            throw new Exception( 'VAT check is currently unavailable.', $e->getCode() );
        }

        return !! $response->valid;
    }

    /**
     * @param string $country
     *
     * @return string
     */
    protected function fixCountryCode( $country ) {
        static $exceptions = array(
            'GR' => 'EL',
            'UK' => 'GB',
        );

        if( isset( $exceptions[$country] ) ) {
            return $exceptions[$country];
        }

        return $country;
    }


}
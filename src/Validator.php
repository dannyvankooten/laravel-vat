<?php
namespace DvK\Laravel\Vat;

use SoapClient;
use Exception;
use SoapFault;


class Validator {

    /**
     * @const string
     */
    const URL = 'http://ec.europa.eu/taxation_customs/vies/checkVatService.wsdl';

    /**
     * @var SoapClient
     */
    private $client;

    /**
     * All valid country codes.
     *
     * @var array
     */
    private static $validCountries = array(
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GB',
        'EL', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT',
        'RO', 'SE', 'SI', 'SK'
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
        return in_array( $country, self::$validCountries );
    }

    /**
     * @param string $vatNumber
     * @param string $countryCode
     * @return boolean
     *
     * @throws Exception
     */
    public function check( $vatNumber, $countryCode = ''  ) {
        $vatNumber = strtoupper( $vatNumber );
        $countryCode = strtoupper( $countryCode );

        // if country code is omitted, use first two chars of vat number
        if( empty( $countryCode ) ) {
            $countryCode = substr( $vatNumber, 0, 2 );
        }

        // strip first two characters of VAT number if it matches the country code
        if( substr( $vatNumber, 0, 2 ) === $countryCode ) {
            $vatNumber = substr( $vatNumber, 2 );
        }

        // check if country is in EU, bail early otherwise.
        if( ! $this->isEuCountry( $countryCode ) ) {
            return false;
        }
        // check vat number format (loose)
        if( ! preg_match('/^[0-9A-Z\-]{2,14}$/', $vatNumber) ) {
            return false;
        }
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

        return $response->valid;
    }


}
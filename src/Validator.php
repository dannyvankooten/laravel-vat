<?php
namespace DvK\Laravel\Vat;

use SoapClient;
use Exception;
use SoapFault;
use StdClass;

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
     * @var array
     */
    private $config = array(
        'connection_timeout' => 15
    );

    /**
     * @var stdClass
     */
    private $lastResponse;

    /**
     * VatValidator constructor.
     *
     * @param array $config
     */
    public function __construct( $config = array() ) {
        $this->config = array_merge( $this->config, $config );
        $this->client = new SoapClient( self::URL, array( $this->config ) );
    }

    /**
     * @param string $vatNumber
     * @param string $countryCode
     * @return boolean
     *
     * @throws Exception
     */
    public function check( $vatNumber, $countryCode = ''  ) {

        // if country code is omitted, use first two chars of vat number
        if( empty( $countryCode ) ) {
            $countryCode = substr( $vatNumber, 0, 2 );
        }

        // strip first two characters of VAT number if it matches the country code
        if( substr( $vatNumber, 0, 2 ) === $countryCode ) {
            $vatNumber = substr( $vatNumber, 2 );
        }

        try {
            $response = $this->client->checkVat(
                array(
                    'countryCode' => $countryCode,
                    'vatNumber' => $vatNumber
                )
            );
        } catch( SoapFault $e ) {
            throw new Exception( 'VAT check is currently unavailable.', 500 );
        }

        $this->lastResponse = $response;
        return $response->valid;
    }

    /**
     * @return stdClass
     */
    public function getLastResponse() {
        return $this->lastResponse;
    }


}
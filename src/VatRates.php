<?php

namespace DvK\VatRates;

use GuzzleHttp\Client;

class VatRates {

    /**
     * @const string
     */
    const URL = 'https://jsonvat.com/';

    /**
     * @var Client
     */
    private $client;

    /**
     * VatValidator constructor.
     *
     * @param Client $client
     */
    public function __construct( Client $client ) {
        $this->client = $client;
    }

    private function fetch() {
        $response = $this->client->request( 'GET', self::URL );
        $data = json_decode( $response->getBody() );
        var_dump( $data );
    }

    public function all() {

    }

    public function country( $country ) {
        $country = $this->getCountryCode( $country );

    }

    /**
     * @param string $country
     * @return string
     */
    private function getCountryCode( $country ) {

        // # Fix ISO-3166-1-alpha2 exceptions
        if( $country == 'UK' ) {
            $country = 'GB';
        }

        if( $country == 'EL' ) {
            $country = 'GR';
        }

        return $country;
    }



}
<?php

namespace DvK\VatRates;

class VatRates {

    /**
     * @const string
     */
    const URL = 'https://jsonvat.com/';

    /**
     * VatValidator constructor.
     */
    public function __construct(  ) {

    }

    private function fetch() {
        $response = file_get_contents( self::URL );
        $data = json_decode( $response );
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

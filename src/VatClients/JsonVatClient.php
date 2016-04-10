<?php

namespace DvK\Laravel\Vat\VatClients;

class JsonVatClient implements VatClient{

    /**
     * @const string
     */
    const URL = 'https://jsonvat.com/';

    /**
     * @throws VatClientException
     *
     * @return array
     */
    public function fetch() {
        $url = self::URL;

        // fetch data
        $response = file_get_contents($url);
        if( empty( $response ) ) {
            throw new VatClientException( "Error fetching rates from {$url}.");
        }
        $data = json_decode($response);

        // build map with country codes => rates
        $map = array();
        foreach ($data->rates as $rate) {
            $map[$rate->country_code] = $rate->periods[0]->rates;
        }

        return $map;
    }
}
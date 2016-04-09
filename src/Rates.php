<?php

namespace DvK\Laravel\Vat;

use Exception;
use Illuminate\Contracts\Cache\Repository as Cache;

class Rates
{

    /**
     * @const string
     */
    const URL = 'https://jsonvat.com/';

    /**
     * @var array
     */
    private $map = array();

    /**
     * @var Cache
     */
    private $cache;

    /**
     * VatValidator constructor.
     *
     * @param Cache $cache
     */
    public function __construct(Cache $cache = null)
    {
        $this->cache = $cache;
        $this->map = $this->load();
    }

    private function load()
    {
        // load from cache
        if ($this->cache) {
            $map = $this->cache->get('vat-rates');
        }

        // fetch from jsonvat.com
        if (empty($map)) {
            $map = $this->fetch();

            // store in cache
            if ($this->cache) {
                $this->cache->put('vat-rates', $map, 86400);
            }
        }

        return $map;
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    private function fetch()
    {
        $url = self::URL;

        // fetch data
        $response = file_get_contents($url);
        if( empty( $response ) ) {
            throw new Exception( "Error fetching rates from {$url}.");
        }
        $data = json_decode($response);

        // build map with country codes => rates
        $map = array();
        foreach ($data->rates as $rate) {
            $map[$rate->country_code] = $rate->periods[0]->rates;
        }

        return $map;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->map;
    }

    /**
     * @param string $country
     * @param string $rate
     *
     * @return double
     *
     * @throws Exception
     */
    public function country($country, $rate = 'standard')
    {
        $country = strtoupper($country);
        $country = $this->getCountryCode($country);

        if (!isset($this->map[$country])) {
            throw new Exception('Invalid country code.');
        }

        if (!isset($this->map[$country]->$rate)) {
            throw new Exception('Invalid rate.');
        }

        return $this->map[$country]->$rate;
    }

    /**
     * Get normalized country code
     *
     * Fixes ISO-3166-1-alpha2 exceptions
     *
     * @param string $country
     * @return string
     */
    private function getCountryCode($country)
    {
        if ($country == 'UK') {
            $country = 'GB';
        }

        if ($country == 'EL') {
            $country = 'GR';
        }

        return $country;
    }


}

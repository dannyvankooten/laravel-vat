<?php

namespace DvK\Laravel\Vat\VatClients;

interface VatClient {

    /**
     * @throws VatClientException
     *
     * @return array
     */
    public function fetch();
}
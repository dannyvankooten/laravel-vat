<?php

namespace DvK\VatRates\Facades;

use Illuminate\Support\Facades\Facade;

class VatRates extends Facade {

    protected static function getFacadeAccessor() { return 'payment'; }

}
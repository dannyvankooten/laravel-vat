<?php

namespace DvK\Laravel\Vat\Facades;

use Illuminate\Support\Facades\Facade;

class Countries extends Facade {

    protected static function getFacadeAccessor() 
    { 
        return \DvK\Vat\Countries::class;
    }

}

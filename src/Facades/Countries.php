<?php

namespace DvK\Laravel\Vat\Facades;

use Illuminate\Support\Facades\Facade;
use DvK\Laravel\Vat\Countries as OG;

class Countries extends Facade {

    protected static function getFacadeAccessor() { return OG::class; }

}

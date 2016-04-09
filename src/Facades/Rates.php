<?php

namespace DvK\Laravel\Vat\Facades;

use Illuminate\Support\Facades\Facade;
use DvK\Laravel\Vat\Rates as OG;

class Rates extends Facade {

    protected static function getFacadeAccessor() { return OG::class; }

}

<?php

namespace DvK\Laravel\Vat\Facades;

use Illuminate\Support\Facades\Facade;
use DvK\Laravel\Vat\Validator as OG;

class Validator extends Facade {

    protected static function getFacadeAccessor() { return OG::class; }

}

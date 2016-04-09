<?php

namespace DvK\Laravel\Vat\Facades;

use Illuminate\Support\Facades\Facade;

class Validator extends Facade {

    protected static function getFacadeAccessor() { return 'vat-validator'; }

}

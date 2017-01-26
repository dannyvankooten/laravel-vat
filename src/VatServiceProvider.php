<?php

namespace DvK\Laravel\Vat;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator as RequestValidator;

use DvK\Laravel\Vat\Vies\ViesException;
use DvK\Laravel\Vat\Facades\Validator as ValidatorFacade;


class VatServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

        /**
         * Register the "vat_number" validation rule.
         *
         * When the VIES VAT validation fails, this will just look at the number format.
         * This can result in invalid VAT numbers being marked as true.
         * With the VIES VAT number API being down an awful lot lately, we feel it is more important to get the purchase through.
         */
        RequestValidator::extend('vat_number', function($attribute, $value, $parameters, $validator ) {
            try {
                $valid = ValidatorFacade::validate( $value );
            }  catch( ViesException $e ) {
                return true;
            }

            return $valid;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton( Countries::class, function (Container $app) {
            return new Countries();
        });

        $this->app->singleton( Validator::class, function (Container $app) {
           return new Validator();
        });

        $this->app->singleton( Rates::class, function (Container $app) {
            $defaultCacheDriver = $app['cache']->getDefaultDriver();
            $cacheDriver = $app['cache']->driver( $defaultCacheDriver );
            return new Rates( $cacheDriver );
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            Validator::class,
            Rates::class,
            Countries::class,
        ];
    }
}

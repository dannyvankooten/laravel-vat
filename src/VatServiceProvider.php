<?php

namespace DvK\Laravel\Vat;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator as RequestValidator;

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
        RequestValidator::extend('vat_number', function($attribute, $value, $parameters, $validator ) {
            return ValidatorFacade::validate( $value );
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

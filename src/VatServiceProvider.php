<?php

namespace DvK\Laravel\Vat;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator as RequestValidator;

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
            $vatValidator = new Validator();
            $data = $validator->getData();
            $country = isset( $data['country'] ) ? $data['country'] : '';
            return $vatValidator->check( $value, $country );
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
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
            'DvK\Laravel\Vat\Validator',
            'DvK\Laravel\Vat\Rates',
        ];
    }
}

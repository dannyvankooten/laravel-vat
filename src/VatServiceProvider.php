<?php

namespace DvK\Laravel\Vat;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class VatServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('vat-validator', function (Container $app) {
           return new Validator();
        });

        $this->app->singleton('vat-rates', function (Container $app) {
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
            'vat-rates',
            'vat-validator',
        ];
    }
}

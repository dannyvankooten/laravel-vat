<?php

namespace DvK\VatRates;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;


class VatRatesServiceProvider extends ServiceProvider
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
        $this->app->singleton('vatrates', function (Container $app) {
            $defaultCacheDriver = $app['cache']->getDefaultDriver();
            $cacheDriver = $app['cache']->driver( $defaultCacheDriver );
            return new VatRates( $cacheDriver );
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
            'vatrates'
        ];
    }
}

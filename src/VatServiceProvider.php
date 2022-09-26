<?php

namespace DvK\Laravel\Vat;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator as LaravelValidator;
use DvK\Laravel\Vat\Facades\Validator as VatValidator;
use DvK\Laravel\Vat\Rules;

use Ibericode\Vat\Countries;
use Ibericode\Vat\Rates\Rates;
use Ibericode\Vat\Validator;

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
         */
        LaravelValidator::extend('vat_number', function ($attribute, $value, $parameters, $validator) {
            $rule = new Rules\VatNumber;
            return $rule->passes($attribute, $value);
        });

         /**
         * Register the "country_code" validation rule.
         */
        LaravelValidator::extend('country_code', function ($attribute, $value, $parameters, $validator) {
            $rule = new Rules\Country;
            return $rule->passes($attribute, $value);
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
            return new Rates( null, $cacheDriver );
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

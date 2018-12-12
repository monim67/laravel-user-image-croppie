<?php

namespace Monim67\LaravelUserImageCroppie;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'lui-croppie');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/lui-croppie'),
        ], 'lang');

        $this->publishes([
            __DIR__.'/../config/lui-croppie.php' => config_path('lui-croppie.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lui-croppie');
    }
}

<?php

namespace YubarajShrestha\NCHL;

use Illuminate\Support\ServiceProvider;
use YubarajShrestha\NCHL\Services\NchlService;

class NchlServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('nchl', function () {
            return new NchlService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/nchl.php' =>  config_path('nchl.php'),
        ], 'nchl');
    }
}

<?php

namespace YubarajShrestha\NCHL;

use Illuminate\Support\Facades\Blade;
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
        Blade::directive('StartNchl', function ($string) {
            $config = config('nchl');
            $template = "<form method='post' action='".$config['gateway']."'>";
            $template .= "<input type='text' name='MERCHANTID' id='MERCHANTID' value='".$config['merchant_id']."'/>";
            $template .= "<input type='text' name='APPID' id='APPID' value='".$config['app_id']."'/>";
            $template .= "<input type='text' name='APPNAME' id='APPNAME' value='".$config['app_name']."'/>";
            $template .= "<input type='text' name='TXNCRNCY' id='TXNCRNCY' value='".$config['txn_currency']."'/>";

            return $template;
        });

        Blade::directive('EndNchl', function ($string) {
            $template = "<input type='submit' class='nchl-button' value='Submit'></form>";

            return $template;
        });

        $this->publishes([
            __DIR__.'/Config/nchl.php' => config_path('nchl.php'),
        ], 'nchl');
    }
}

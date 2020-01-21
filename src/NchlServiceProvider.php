<?php

namespace YubarajShrestha\NCHL;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use YubarajShrestha\NCHL\Services\NchlService;

class NchlServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind('nchl', function () {
            return new NchlService();
        });
        $this->app->make('YubarajShrestha\NCHL\Services\NchlService');
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/nchl.php' => config_path('nchl.php')
        ], 'config');

        // $this->publishes([
        //     __DIR__.'/../database/migrations/create_connectips_table.php.stub' => $this->getMigrationFileName($filesystem),
        // ], 'migrations');

    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param Filesystem $filesystem
     * @return string
     */
    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path.'*_create_connectips_table.php');
            })->push($this->app->databasePath()."/migrations/{$timestamp}_create_connectips_table.php")
            ->first();
    }
}

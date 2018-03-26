<?php

namespace GavinHewitt\Snipper;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class SnipperServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupPackage();
        $this->setupRoutes($this->app->router);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Setup the package.
     *
     * @return void
     */
    protected function setupPackage()
    {
//        $source = realpath(__DIR__.'/../config/contact.php');

//        $this->publishes([$source => config_path('instructo/contact.php')]);

//        $this->mergeConfigFrom($source, 'instructo.contact');

        $this->setupPublish();

        $this->loadConfiguration();
        $this->loadViewsFrom(resource_path('views/vendor/snipper'), 'snipper');
        $this->loadViewsFrom(__DIR__.'/views', 'snipper');
    }

    /**
     * Setup the routes.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    protected function setupRoutes(Router $router)
    {
        $router->group([
//            'namespace' => 'GavinHewitt\Snipper\Http\Controllers',
            'namespace' => 'GavinHewitt\Snipper',
            'prefix' => config('snipper.prefix'),
            'middleware'=> 'web'], function (Router $router) {
            require __DIR__.'/routes.php';
        });
    }

    /**
     * Load the configuration files and allow them to be published.
     *
     * @return void
     */
    protected function loadConfiguration()
    {
        $this->publishes([__DIR__.'/config/snipper.php' => config_path('/snipper.php')]);

        $this->mergeConfigFrom(__DIR__ .'/config/snipper.php', 'snipper');
    }

    protected function setupPublish() {
        $this->publishes([__DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'], 'migrations');
    }
}
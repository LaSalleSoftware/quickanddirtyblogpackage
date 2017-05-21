<?php

namespace Lasallesoftware\Quickanddirtyblog;

/**
 *
 * Internal API package for the LaSalle Content Management System, based on the Laravel 5 Framework
 * Copyright (C) 2015 - 2016  The South LaSalle Trading Corporation
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @package    Very quick and dirty blog package based on my LaSalle Software v1
 * @link       http://LaSalleSoftware.ca
 * @copyright  (c) 2017, The South LaSalle Trading Corporation
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @author     The South LaSalle Trading Corporation
 * @email      bob.bloom@lasallesoftware.ca
 *
 */

// Laravel classes
use Illuminate\Support\ServiceProvider;

/**
 * This is the User Management service provider class.
 *
 * @author Bob Bloom <info@southlasalle.com>
 */
class QuickanddirtyblogServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfiguration();
        $this->setupMigrations();
        $this->setupSeeds();
        $this->setupRoutes();
        $this->setupViews();
        //$this->setupAssets();
    }

    /**
     * Setup the Configuration.
     *
     * @return void
     */
    protected function setupConfiguration()
    {
        $configuration = realpath(__DIR__.'/../config/quickanddirtyblog.php');

        $this->publishes([
            $configuration => config_path('quickanddirty.php'),
        ]);
    }

    /**
     * Setup the Migrations.
     *
     * @return void
     */
    protected function setupMigrations()
    {
        $migrations = realpath(__DIR__.'/../database/migrations');

        $this->loadMigrationsFrom($migrations);
    }

    /**
     * Setup the Seeds.
     *
     * @return void
     */
    protected function setupSeeds()
    {
        $seeds = realpath(__DIR__.'/../database/seeds');

        $this->publishes([
            $seeds    => $this->app->databasePath() . '/seeds',
        ]);
    }

    /**
     * Setup the Routes.
     *
     * @return void
     */
    protected function setupRoutes()
    {
        $routes = realpath(__DIR__.'/../routes/routes.php');

        $this->loadRoutesFrom($routes);
    }

    /**
     * Setup the Views.
     *
     * @return void
     */
    protected function setupViews()
    {
        $views = realpath(__DIR__.'/../views');

        $this->loadViewsFrom($views, 'quickanddirtyblog');

        $this->publishes([
            $views => resource_path('views/vendor/lasallesoftware/quickanddirtyblog'),
        ]);
    }

    /**
     * Define the assets for the application.
     *
     * @return void
     */
    public function setupAssets()
    {
        $assets = realpath(__DIR__.'/../assets');

        $this->publishes([
           $assets => public_path('packages/lasallesoftware/quickanddirtyblog/'),
        ], 'public');
    }



    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //$this->registerQuickanddirtyblog();
    }


    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerQuickanddirtyblog()
    {
        $this->app->bind('quickanddirtyblog', function($app) {
            return new Quickanddirtyblog($app);
        });
    }
}
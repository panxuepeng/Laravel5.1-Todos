<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Supports\Cms;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cms', function($app)
        {
            return new Cms();
        });
    }
}

<?php

namespace Mathays\Providers;

use Illuminate\Support\ServiceProvider;

use Mathays\Setting;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('settings', function ($app) {
            // return $app['cache']->remember('site.settings', 60, function () {
                return Setting::pluck('value', 'key')->toArray();
            // });
        });
    }
}

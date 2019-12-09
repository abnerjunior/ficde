<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */

public function boot()
{
    Schema::defaultStringLength(191);
}
	public function register()
    {
        //
        if ($this->app->environment() == 'local') {
            $this->app->register(\Wn\Generators\CommandsServiceProvider::class);
        }
    }
}

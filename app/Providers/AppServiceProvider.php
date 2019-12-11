<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */


     public function boot()
     {
        /** tuve que poner esto aca porque me daban error las migraciones -Abner */
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

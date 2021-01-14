<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Services\Interfaces\UserServiceInterface',
            'App\Services\UserService'
        );

        $this->app->bind(
            'App\Services\Interfaces\BookServiceInterface',
            'App\Services\BookService'
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

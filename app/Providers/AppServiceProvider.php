<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Managers\UserManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('user_manager',function() {
            return UserManager();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

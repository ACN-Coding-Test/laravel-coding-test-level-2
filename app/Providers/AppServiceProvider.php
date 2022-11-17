<?php

namespace App\Providers;

use App\Services\Roles\Admin;
use App\Services\Roles\Developer;
use App\Services\Roles\ProductOwner;
use App\Services\Roles\Role;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('roleService', function ($app) {
            return new Role();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app('roleService')
            ->addRole(new Admin())
            ->addRole(new Developer())
            ->addRole(new ProductOwner());
    }
}

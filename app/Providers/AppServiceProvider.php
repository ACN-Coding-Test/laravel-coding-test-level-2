<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\Client;
use Ramsey\Uuid\Uuid;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Passport::ignoreMigrations();

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Client::creating(function (Client $client) {
            $client->incrementing = false;
            $client->id = \Ramsey\Uuid\Uuid::uuid4()->toString();
        });
        
        Client::retrieved(function (Client $client) {
            $client->incrementing = false;
        });
    }
}

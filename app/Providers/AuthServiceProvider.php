<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('ADMIN', function(User $user) {
            if($user->role_id===1) {
                return true;
            }
        });

        Gate::define('PRODUCT_OWNER', function(User $user) {
            if($user->role_id===2) {
                return true;
            }
        });

        Gate::define('TEAM_MEMBER', function(User $user) {
            if($user->role_id===3) {
                return true;
            }
        });
    }
}

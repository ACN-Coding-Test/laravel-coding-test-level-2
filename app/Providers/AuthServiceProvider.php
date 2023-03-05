<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        Gate::define('isAdmin', function($user) {
            return $user->role == 'ADMIN';
        });

        Gate::define('isProductOwner', function($user) {
            return $user->role == 'PRODUCT_OWNER';
        });

        Gate::define('isTeamMember', function($user) {
            return $user->role == 'TEAM_MEMBER';
        });

        Gate::define('updateProject', function ($user, $project) {
          return $user->id == $project->product_owner_id;
        });

        Gate::define('taskCreateByOwner', function ($user, $project) {
          return $user->id == $project->product_owner_id;
        });

        Gate::define('taskByOwner', function ($user, $task) {
          return $user->id == $task->task_owner_id;
        });

        Gate::define('taskByTeamMember', function ($user, $task) {
          return $user->id == $task->team_member_id;
        });

    }
}

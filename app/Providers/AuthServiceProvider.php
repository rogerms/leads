<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Permission;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $permissions = Permission::with('roles')->get();

        $gate->before(function ($user, $ability) {
            if ($user->role_id < 3 ) { //admin 2, superadmin 1
                return true;
            }
        });

        $gate->define('view-proposal', function($user, $job){
            return  $user->role_id == 3  || $job->proposal_author == $user->id || empty($job->proposal_author);
        });

        foreach($permissions as $permission)
        {
            $gate->define($permission->slug, function($user) use($permission)
            {
                return $permission->roles->contains($user->role);
            });
        }

    }
}

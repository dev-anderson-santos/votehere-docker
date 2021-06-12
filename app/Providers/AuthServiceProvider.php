<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\RoleModel;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
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

        Gate::define('see-others', function ($user) {
            
            $role = RoleModel::whereId(RoleModel::ADMINISTRADOR)->first();
            $aux = $user->roleUser()->get()->pluck('role_id')->toArray();
            

            return in_array($role->id, $aux);

        });
    }
}

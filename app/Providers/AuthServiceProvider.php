<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        //phẩn quyền
        Gate::define('modules',function($user,$permissionName) {
          if(!empty($user) && $user->status != 1) {
            return false;
          } 
          $permission = $user->user_cataloge->permissions;
          if($permission->contains('canonical',$permissionName)) {
             return true;
          }
          return false;
        });
    }
}

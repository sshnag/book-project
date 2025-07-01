<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
            //

            Gate::define('manage-users',function($user){
                return $user->hasAnyRole(['superadmin']);
            });
            Gate::define('access-admindashboard',function($user){
                return $user->hasAnyRole(['superadmin','bookadmin']);
            });

    }
}

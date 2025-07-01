<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
            //for pagination style
                Paginator::useBootstrapFive();


            Gate::define('manage-users',function($user){
                return $user->hasAnyRole(['superadmin']);
            });
            Gate::define('access-admindashboard',function($user){
                return $user->hasAnyRole(['superadmin','bookadmin']);
            });

    }
}

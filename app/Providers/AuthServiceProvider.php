<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\Bookpolicy;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Policies\AuthorPolicy;
use App\Policies\CategoryPOlicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Book::class=>Bookpolicy::class,
        Category::class=>CategoryPOlicy::class,
        Author::class=>AuthorPolicy::class,
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define your gates here, e.g.
        // Gate::define('create-post', function ($user) {
        //     return $user->role === 'admin';
        // });
    }
}

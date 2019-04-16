<?php

namespace Corp\Providers;

use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Corp\User;
use Corp\Article;
use Corp\Permission;
use Corp\Policies\ArticlePolicy;
use Corp\Policies\PermissionPolicy;
use Corp\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Permission::class => PermissionPolicy::class,
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('VIEW_ADMINS', function ($user) {
            return $user->canDo(['VIEW_ADMINS'], false);
        });

        Gate::define('VIEW_ADMIN_ARTICLES', function ($user) {
            return $user->canDo(['VIEW_ADMIN_ARTICLES'], false);
        });

        Gate::define('VIEW_ADMIN_MENU', function ($user) {
            return $user->canDo(['VIEW_ADMIN_MENU'], false);
        });

        Gate::define('EDIT_USERS', function ($user) {
            return $user->canDo(['EDIT_USERS'], false);
        });

        Gate::define('CREATE_USERS', function ($user) {
            return $user->canDo(['CREATE_USERS'], false);
        });
    }
}

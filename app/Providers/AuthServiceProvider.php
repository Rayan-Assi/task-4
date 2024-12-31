<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
/* use Illuminate\Support\ServiceProvider;
 */

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Post::class => PostPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('manageUser', function ($user) {
            return $user->is_admin;
        });
    }
}

<?php

namespace App\Providers;

use App\Models\User;
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
        Gate::define('create-videos', fn(User $user) => $user->hasPermissionTo('create videos'));
        Gate::define('edit-videos', fn(User $user) => $user->hasPermissionTo('edit videos'));
        Gate::define('delete-videos', fn(User $user) => $user->hasPermissionTo('delete videos'));

        Gate::define('manage-users', function (User $user){
            return $user->isSuperAdmin();
        });

        Gate::define('manage-videos', function (User $user){
           return $user->hasRole('video_manager') || $user->isSuperAdmin();
        });

    }
}

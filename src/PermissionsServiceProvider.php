<?php

namespace Wijzijnweb\LaravelInertiaPermissions;


use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        Inertia::share([
            'user_permissions' => function () {
                $user = auth()->user();

                if($user) {
                    return [
                        'permissions' => $user->getAllPermissions()->pluck('name'),
                        'roles' => $user->getRoleCodes()
                    ];
                }
                return [];
            },
            'permissions' => function() {
                return [
                    'permissions' => Permission::get(),
                    'roles' => Role::get()
                ];
            }
        ]);
    }
}
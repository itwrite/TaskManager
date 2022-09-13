<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TaskRepository::class, \App\Repositories\TaskRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SettingRepository::class, \App\Repositories\SettingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TaskItemRepository::class, \App\Repositories\TaskItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AreaRepository::class, \App\Repositories\AreaRepositoryEloquent::class);
        //:end-bindings:
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // // Security Repository
        // $this->app->singleton(
        //     \App\Repositories\RepositoryInterface::class,
        //     \App\Repositories\EloquentRepository::class,
        //     // \App\Repositories\Company\CompanyRepository::class,
        // );
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

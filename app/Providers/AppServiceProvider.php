<?php

namespace App\Providers;

use App\Repository\Providers\Register as RepositoryRegister;
use App\Services\Providers\Register as ServicesRegister;
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
        RepositoryRegister::register($this->app);
        ServicesRegister::register($this->app);
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

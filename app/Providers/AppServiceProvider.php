<?php

namespace App\Providers;

use App\Models\Car;
use App\Models\Owner;
use App\Policies\CarPolicy;
use App\Policies\OwnerPolicy;
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
        Gate::policy(Owner::class, OwnerPolicy::class);
        Gate::policy(Car::class, CarPolicy::class);
    }
}

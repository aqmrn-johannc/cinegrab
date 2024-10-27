<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Movie;
use App\Observers\MovieObserver;

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
    public function boot()
    {
        // MAKE SURE TO COMMENT THIS OUT BEFORE MIGRATING AND SEEDING . THIS ASSHOLE CREATES ANOTHER SETS OF SEATS FOR THE MOVIES WHEN MIGRATING.
        Movie::observe(MovieObserver::class);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Dusk\DuskServiceProvider;
use App\Validators\ParticipantValidators;
use App\Validators\ScoreValidators;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \Laravel\Passport\Passport::withoutCookieSerialization();

        ParticipantValidators::init();
        ScoreValidators::init();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

    }
}

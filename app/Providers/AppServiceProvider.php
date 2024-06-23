<?php

namespace App\Providers;

use App\Validators\VersionObjectValue;
use Illuminate\Support\ServiceProvider;
use Validator;

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
        Validator::extend("version_object_value", VersionObjectValue::class, "Invalid object value.");
    }
}

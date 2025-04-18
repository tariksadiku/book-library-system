<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Book\GetBookImageInterface;
use App\Services\Book\GetBookImageService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GetBookImageInterface::class, GetBookImageService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

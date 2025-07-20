<?php

namespace App\Providers;

use App\Services\SupabaseAssetService;
use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SupabaseAssetService::class, function ($app) {
            return new SupabaseAssetService();
        });

        // Bind with an alias for easier access
        $this->app->alias(SupabaseAssetService::class, 'asset.service');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

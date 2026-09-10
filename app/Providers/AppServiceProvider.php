<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Helpers/blogger_helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $apiClient = app(\App\Services\BloggerApiClient::class);
                $adsData = $apiClient->getWebsiteAds();
                $adsEnabled = (bool) ($adsData['ads_enabled'] ?? false);
                $websiteAds = (array) ($adsData['ads'] ?? []);

                $view->with('adsEnabled', $adsEnabled)
                     ->with('websiteAds', $websiteAds);
            } catch (\Throwable $e) {
                $view->with('adsEnabled', false)
                     ->with('websiteAds', []);
            }
        });
    }
}

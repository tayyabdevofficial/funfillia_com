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
            static $sharedData = null;

            if ($sharedData === null) {
                try {
                    $apiClient = app(\App\Services\BloggerApiClient::class);
                    $adsData = $apiClient->getWebsiteAds();
                    $sharedData = [
                        'adsEnabled' => (bool) ($adsData['ads_enabled'] ?? false),
                        'websiteAds' => (array) ($adsData['ads'] ?? []),
                    ];
                } catch (\Throwable $e) {
                    $sharedData = [
                        'adsEnabled' => false,
                        'websiteAds' => [],
                    ];
                }
            }

            $view->with('adsEnabled', $sharedData['adsEnabled'])
                 ->with('websiteAds', $sharedData['websiteAds']);
        });
    }
}

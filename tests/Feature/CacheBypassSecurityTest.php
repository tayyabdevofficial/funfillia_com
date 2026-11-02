<?php

use App\Services\BloggerApiClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

test('anonymous visitor cannot bypass cache using nocache or refresh parameters', function () {
    Config::set('blogger.api_url', 'http://127.0.0.1:8000/api/v1');
    Config::set('blogger.api_key', 'test_key');
    Config::set('blogger.api_secret', 'test_secret');
    Config::set('blogger.cache_enabled', true);

    $apiKey = 'test_key';
    $path = '/website/home';
    $tenantCacheVer = Cache::get('blogger_cache_ver_' . $apiKey, 1);
    $cacheKey = 'blogger_api_' . md5($apiKey . '_' . $tenantCacheVer . '_' . $path);

    Cache::put($cacheKey, ['from_cache' => true], 300);

    // Simulate request with ?nocache=1
    $this->get('/?nocache=1');

    $client = app(BloggerApiClient::class);
    $result = $client->get($path);

    // Should return cached response instead of bypassing
    expect($result)->toBe(['from_cache' => true]);
});

test('authorized request with matching bypass token can bypass cache', function () {
    Config::set('blogger.api_url', 'http://127.0.0.1:8000/api/v1');
    Config::set('blogger.api_key', 'test_key');
    Config::set('blogger.api_secret', 'test_secret');
    Config::set('blogger.bypass_token', 'super_secret_bypass_token');
    Config::set('blogger.cache_enabled', true);

    Http::fake([
        '*' => Http::response(['fresh_data' => true], 200),
    ]);

    $apiKey = 'test_key';
    $path = '/website/home';
    $tenantCacheVer = Cache::get('blogger_cache_ver_' . $apiKey, 1);
    $cacheKey = 'blogger_api_' . md5($apiKey . '_' . $tenantCacheVer . '_' . $path);

    Cache::put($cacheKey, ['from_cache' => true], 300);

    // Simulate request with authorized bypass token
    $this->withHeaders(['X-Bypass-Cache' => 'super_secret_bypass_token'])->get('/?refresh=1');

    $client = app(BloggerApiClient::class);
    $result = $client->get($path);

    expect($result)->toBe(['fresh_data' => true]);
});


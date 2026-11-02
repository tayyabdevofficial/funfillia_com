<?php

use App\Services\BloggerApiClient;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

test('webhook rejects requests without signature header', function () {
    Config::set('blogger.api_secret', 'test_secret_123');

    $response = $this->postJson('/api/webhook/purge-cache', [
        'event' => 'cache.purge',
        'data' => [],
    ]);

    $response->assertStatus(401);
    $response->assertJson([
        'success' => false,
    ]);
});

test('webhook rejects requests with invalid signature', function () {
    Config::set('blogger.api_secret', 'test_secret_123');

    $response = $this->withHeaders([
        'X-AutomateWrite-Signature' => 'invalid_signature_hash',
    ])->postJson('/api/webhook/purge-cache', [
        'event' => 'cache.purge',
        'data' => [],
    ]);

    $response->assertStatus(403);
    $response->assertJson([
        'success' => false,
        'error' => 'Invalid signature',
    ]);
});

test('webhook accepts valid HMAC signature and increments tenant cache version without flushing app cache', function () {
    $secret = 'test_secret_123';
    $apiKey = 'aw_live_test_api_key';
    Config::set('blogger.api_secret', $secret);
    Config::set('blogger.api_key', $apiKey);

    // Set other app cache data to ensure it is not flushed
    Cache::put('system_unrelated_key', 'safe_value', 3600);
    $initialVersion = Cache::get('blogger_cache_ver_' . $apiKey, 1);

    $payload = [
        'event' => 'cache.purge',
        'website_id' => 1,
        'data' => ['slug' => 'test-post'],
    ];
    $rawBody = json_encode($payload);
    $signature = hash_hmac('sha256', $rawBody, $secret);

    $response = $this->withHeaders([
        'X-AutomateWrite-Signature' => $signature,
    ])->postJson('/api/webhook/purge-cache', $payload);

    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
        'purged' => true,
    ]);

    // Unrelated cache must remain intact
    expect(Cache::get('system_unrelated_key'))->toBe('safe_value');

    // Tenant cache version must be incremented
    $newVersion = Cache::get('blogger_cache_ver_' . $apiKey);
    expect($newVersion)->toBe($initialVersion + 1);
});


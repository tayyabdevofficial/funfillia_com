<?php

use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Milestone 0 — Webhook purge endpoint (fail closed, tenant-scoped)
|--------------------------------------------------------------------------
| POST /api/webhook/purge-cache must refuse unsigned/invalid requests
| without touching the cache, and on a valid HMAC signature must purge
| only this tenant's registered BloggerApiClient keys — never a global
| Cache::flush().
*/

function seedTenantCacheEntry(): void
{
    Cache::put('blogger_api_deadbeefcafe', ['some' => 'data'], now()->addMinutes(5));
    Cache::forever('blogger_api_key_registry', ['blogger_api_deadbeefcafe']);
    // An unrelated cache entry that a global flush would wrongly destroy:
    Cache::put('unrelated_app_key', 'keep-me', now()->addMinutes(5));
}

function postWebhook($test, ?string $signature, string $body)
{
    $headers = $signature === null ? [] : ['X-AutomateWrite-Signature' => $signature];

    return $test->withHeaders($headers)
        ->call('POST', '/api/webhook/purge-cache', [], [], [], ['CONTENT_TYPE' => 'application/json'], $body);
}

beforeEach(function () {
    config(['blogger.api_secret' => 'test-webhook-secret']);
    seedTenantCacheEntry();
    $this->body = json_encode(['event' => 'cache.purge', 'data' => []]);
});

test('missing signature is rejected and purges nothing', function () {
    postWebhook($this, null, $this->body)->assertStatus(401);

    expect(Cache::has('blogger_api_deadbeefcafe'))->toBeTrue()
        ->and(Cache::has('unrelated_app_key'))->toBeTrue();
});

test('invalid signature is rejected and purges nothing', function () {
    postWebhook($this, 'deadbeef-not-a-valid-signature', $this->body)->assertStatus(403);

    expect(Cache::has('blogger_api_deadbeefcafe'))->toBeTrue()
        ->and(Cache::has('unrelated_app_key'))->toBeTrue();
});

test('valid signature purges only the tenant keys', function () {
    $signature = hash_hmac('sha256', $this->body, 'test-webhook-secret');

    postWebhook($this, $signature, $this->body)
        ->assertOk()
        ->assertJson(['success' => true, 'purged' => true]);

    expect(Cache::has('blogger_api_deadbeefcafe'))->toBeFalse()
        ->and(Cache::has('blogger_api_key_registry'))->toBeFalse()
        // …while unrelated cache entries survive (no global flush).
        ->and(Cache::has('unrelated_app_key'))->toBeTrue();
});

test('no configured secret fails closed with 503', function () {
    config(['blogger.api_secret' => '']);
    $signature = hash_hmac('sha256', $this->body, 'anything');

    postWebhook($this, $signature, $this->body)->assertStatus(503);

    expect(Cache::has('blogger_api_deadbeefcafe'))->toBeTrue();
});

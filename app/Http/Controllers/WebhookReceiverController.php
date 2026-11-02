<?php

namespace App\Http\Controllers;

use App\Services\BloggerApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WebhookReceiverController extends Controller
{
    /**
     * Process incoming webhooks from AutomateWrite (Instant cache purge & events).
     */
    public function handle(Request $request)
    {
        $signature = $request->header('X-AutomateWrite-Signature');
        $rawContent = $request->getContent();
        $secret = config('blogger.webhook_secret') ?: config('blogger.api_secret');

        // Signature verification is strictly MANDATORY
        if (empty($secret) || empty($signature)) {
            Log::warning('Unauthorized webhook attempt to funfillia_com: missing secret or signature.');
            return response()->json(['success' => false, 'error' => 'Missing signature or webhook secret unconfigured'], 401);
        }

        $expectedSignature = hash_hmac('sha256', $rawContent, $secret);
        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning('Unauthorized webhook attempt to funfillia_com: signature mismatch.');
            return response()->json(['success' => false, 'error' => 'Invalid signature'], 403);
        }

        $event = $request->input('event', 'cache.purge');
        $data = $request->input('data', []);

        // Purge only current tenant's cache keys
        $apiKey = (string) config('blogger.api_key', '');
        BloggerApiClient::purgeTenantCache($apiKey);

        Log::info("AutomateWrite webhook received [{$event}]: Tenant cache successfully purged.", [
            'event' => $event,
            'website_id' => $request->input('website_id'),
        ]);

        return response()->json([
            'success' => true,
            'purged' => true,
            'event' => $event,
            'timestamp' => time(),
        ]);
    }

    /**
     * Health check endpoint for heartbeat monitoring.
     */
    public function health()
    {
        return response()->json([
            'status' => 'healthy',
            'domain' => config('site.domain', 'funfillia.com'),
            'app_name' => config('site.name', 'Funfillia'),
            'php_version' => PHP_VERSION,
            'timestamp' => time(),
        ]);
    }
}

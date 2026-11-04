<?php

namespace App\Http\Controllers;

use App\Services\BloggerApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookReceiverController extends Controller
{
    /**
     * Process incoming webhooks from AutomateWrite (instant cache purge & events).
     *
     * Milestone 0 — fail closed:
     *  - no API secret configured        -> 503, nothing is purged;
     *  - missing signature header         -> 401, nothing is purged;
     *  - signature mismatch               -> 403, nothing is purged;
     *  - valid signature                  -> tenant-scoped purge only
     *    (the old behaviour flushed the ENTIRE cache store for everyone).
     */
    public function handle(Request $request, BloggerApiClient $client)
    {
        $secret = (string) config('blogger.api_secret', '');
        $rawContent = $request->getContent();

        if ($secret === '') {
            Log::warning('AutomateWrite webhook refused: no API secret configured (fail closed).');

            return response()->json(['success' => false, 'error' => 'Webhook not configured'], 503);
        }

        $signature = $request->header('X-AutomateWrite-Signature');

        if (!$signature) {
            Log::warning('AutomateWrite webhook refused: missing signature header.');

            return response()->json(['success' => false, 'error' => 'Missing signature'], 401);
        }

        $expectedSignature = hash_hmac('sha256', $rawContent, $secret);

        if (!hash_equals($expectedSignature, $signature)) {
            Log::warning('AutomateWrite webhook refused: signature mismatch.');

            return response()->json(['success' => false, 'error' => 'Invalid signature'], 403);
        }

        $event = $request->input('event', 'cache.purge');
        $data = $request->input('data', []);

        // Purge ONLY this tenant's registered API cache keys.
        $client->purgeTenantCache();
        Log::info("AutomateWrite webhook received [{$event}]: tenant cache successfully purged.", is_array($data) ? $data : []);

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

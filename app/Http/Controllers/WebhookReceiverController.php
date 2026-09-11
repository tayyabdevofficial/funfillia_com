<?php

namespace App\Http\Controllers;

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
        $secret = config('blogger.api_secret');

        // Verify HMAC signature if secret is configured
        if ($secret && $signature) {
            $expectedSignature = hash_hmac('sha256', $rawContent, $secret);
            if (!hash_equals($expectedSignature, $signature)) {
                Log::warning('Unauthorized webhook attempt to funfillia_com: signature mismatch.');
                return response()->json(['success' => false, 'error' => 'Invalid signature'], 403);
            }
        }

        $event = $request->input('event', 'cache.purge');
        $data = $request->input('data', []);

        // Purge local client cache instantly
        Cache::flush();
        Log::info("AutomateWrite webhook received [{$event}]: Local cache successfully purged.", $data);

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

<?php

namespace App\Http\Controllers;

use App\Services\BloggerApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class MediaProxyController extends Controller
{
    protected BloggerApiClient $client;

    public function __construct(BloggerApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * Proxy obfuscated media tokens so visitors never see backend domain or file paths.
     */
    public function stream(Request $request, string $token)
    {
        // Sanitize token: only allow alphanumeric, dashes, underscores, dots
        if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $token)) {
            return redirect('/images/placeholder.svg');
        }

        $cacheDir = storage_path('app/media_cache');
        File::ensureDirectoryExists($cacheDir);

        $cacheFilename = md5($token) . '.webp';
        $cacheFile = $cacheDir . DIRECTORY_SEPARATOR . $cacheFilename;

        // Serve cached media immediately with aggressive browser caching
        if (File::exists($cacheFile)) {
            return response()->file($cacheFile, [
                'Content-Type' => 'image/webp',
                'Cache-Control' => 'public, max-age=31536000, immutable',
            ]);
        }

        // Fetch securely from blogger_admin using HMAC handshake
        $media = $this->client->downloadMediaStream($token);

        if ($media && !empty($media['body'])) {
            File::put($cacheFile, $media['body']);

            return response($media['body'], 200, [
                'Content-Type' => $media['contentType'],
                'Cache-Control' => 'public, max-age=31536000, immutable',
            ]);
        }

        return redirect('/images/placeholder.svg');
    }
}

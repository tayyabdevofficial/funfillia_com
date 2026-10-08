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

        $cacheFilename = md5($token . '_v3_opt70') . '.webp';
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
            $isWebpSaved = false;

            // Compress & optimize with GD into high-efficiency WebP (quality 70 - Google PageSpeed standard)
            if (function_exists('imagecreatefromstring') && function_exists('imagewebp') && !str_contains($media['contentType'] ?? '', 'svg')) {
                try {
                    $img = @imagecreatefromstring($media['body']);
                    if ($img !== false) {
                        imagepalettetotruecolor($img);
                        imagealphablending($img, true);
                        imagesavealpha($img, true);

                        // Downscale if image width exceeds max layout requirement (1200px)
                        $width = imagesx($img);
                        $height = imagesy($img);
                        $maxWidth = 1200;
                        if ($width > $maxWidth && $height > 0) {
                            $newHeight = (int) round(($height * $maxWidth) / $width);
                            $resized = imagecreatetruecolor($maxWidth, $newHeight);
                            imagealphablending($resized, false);
                            imagesavealpha($resized, true);
                            imagecopyresampled($resized, $img, 0, 0, 0, 0, $maxWidth, $newHeight, $width, $height);
                            imagedestroy($img);
                            $img = $resized;
                        }

                        // Save with quality 70 (Google PageSpeed / Lighthouse optimal compression threshold)
                        if (@imagewebp($img, $cacheFile, 70)) {
                            $isWebpSaved = true;
                        }
                        imagedestroy($img);
                    }
                } catch (\Throwable $e) {
                    $isWebpSaved = false;
                }
            }

            if (!$isWebpSaved && !File::exists($cacheFile)) {
                File::put($cacheFile, $media['body']);
            }

            return response()->file($cacheFile, [
                'Content-Type' => $isWebpSaved ? 'image/webp' : ($media['contentType'] ?? 'image/webp'),
                'Cache-Control' => 'public, max-age=31536000, immutable',
            ]);
        }

        return redirect('/images/placeholder.svg');
    }
}

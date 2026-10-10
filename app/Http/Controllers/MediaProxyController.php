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

        $w = (int) $request->query('w', 0);
        $targetWidth = $w > 0 ? min(1200, max(150, $w)) : 800;
        $quality = 65; // High-efficiency WebP compression meeting Google PageSpeed savings threshold

        $cacheDir = storage_path('app/media_cache');
        File::ensureDirectoryExists($cacheDir);

        $cacheFilename = md5($token . '_v5_w' . $targetWidth . '_q' . $quality) . '.webp';
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

            // Compress & optimize with GD into high-efficiency WebP
            if (function_exists('imagecreatefromstring') && function_exists('imagewebp') && !str_contains($media['contentType'] ?? '', 'svg')) {
                try {
                    $img = @imagecreatefromstring($media['body']);
                    if ($img !== false) {
                        imagepalettetotruecolor($img);
                        imagealphablending($img, true);
                        imagesavealpha($img, true);

                        // Downscale if image width exceeds layout requirement
                        $width = imagesx($img);
                        $height = imagesy($img);
                        if ($width > $targetWidth && $height > 0) {
                            $newHeight = (int) round(($height * $targetWidth) / $width);
                            $resized = imagecreatetruecolor($targetWidth, $newHeight);
                            imagealphablending($resized, false);
                            imagesavealpha($resized, true);
                            imagecopyresampled($resized, $img, 0, 0, 0, 0, $targetWidth, $newHeight, $width, $height);
                            imagedestroy($img);
                            $img = $resized;
                        }

                        // Save with quality 65 (ideal balance of crisp fidelity and low byte weight)
                        if (@imagewebp($img, $cacheFile, $quality)) {
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

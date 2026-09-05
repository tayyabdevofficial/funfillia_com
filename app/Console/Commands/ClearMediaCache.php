<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearMediaCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:clear-cache {--days=7 : Remove cached files older than N days} {--all : Purge all media cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear or prune cached media proxy files from storage/app/media_cache';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $cacheDir = storage_path('app/media_cache');
        if (!File::exists($cacheDir)) {
            $this->info("Media cache directory does not exist yet ({$cacheDir}).");
            return 0;
        }

        $files = File::files($cacheDir);
        $totalFiles = count($files);

        if ($totalFiles === 0) {
            $this->info("Media cache is already empty.");
            return 0;
        }

        $purgeAll = $this->option('all');
        $days = (int) $this->option('days');
        $thresholdTime = now()->subDays($days)->timestamp;

        $deletedCount = 0;
        $freedBytes = 0;

        foreach ($files as $file) {
            $lastModified = $file->getMTime();
            if ($purgeAll || $lastModified < $thresholdTime) {
                $freedBytes += $file->getSize();
                File::delete($file->getPathname());
                $deletedCount++;
            }
        }

        $freedMb = round($freedBytes / (1024 * 1024), 2);
        if ($purgeAll) {
            $this->info("Successfully purged entire media cache: {$deletedCount} files deleted ({$freedMb} MB freed).");
        } else {
            $this->info("Pruned {$deletedCount} media files older than {$days} days ({$freedMb} MB freed). {$totalFiles} total files before.");
        }

        return 0;
    }
}

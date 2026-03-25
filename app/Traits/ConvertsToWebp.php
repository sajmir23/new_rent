<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use Illuminate\Support\Str;
use Exception;

trait ConvertsToWebp
{
    /**
     * Convert uploaded image to webp and store it.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $folder  (relative to disk root)
     * @param  string  $disk
     * @param  int  $quality  (0-100)
     * @return string  storage path (e.g. '.../xxx.webp')
     *
     * @throws \Exception
     */
    protected function convertAndStoreWebp(UploadedFile $file, string $folder = 'images', string $disk = 'public', int $quality = 80): string
    {
        $allowed = ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'webp', 'tiff', 'avif'];

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'bin');

        // If not a known image extension, store original file
        if (!in_array($extension, $allowed, true)) {
            return $file->store($folder, $disk);
        }

        // ensure directory exists
        Storage::disk($disk)->makeDirectory($folder);

        // unique filename
        $filename = (string) Str::uuid() . '.webp';
        $relativePath = rtrim($folder, '/') . '/' . $filename;
        $absolutePath = Storage::disk($disk)->path($relativePath);

        // Choose driver: prefer Imagick if available and supports webp; otherwise GD
        $driver = extension_loaded('imagick') ? new ImagickDriver() : new GdDriver();
        $manager = new ImageManager($driver);

        // Quick runtime check for webp support (gd or imagick)
        if ($driver instanceof GdDriver) {
            if (!function_exists('imagewebp')) {
                throw new Exception('GD library in PHP does not support WEBP (imagewebp missing). Enable or install WEBP support for GD or use Imagick.');
            }
        } elseif ($driver instanceof ImagickDriver) {
            if (!class_exists(\Imagick::class)) {
                throw new Exception(
                    'Imagick extension not installed. Install php-imagick or enable GD WebP support.'
                );
            }
            // Note: We skip getFormats() because it's not supported on all Imagick builds
            // If Imagick can't handle WebP, the conversion will fail gracefully in the try/catch below.
        }

        // Read and convert
        try {
            $image = $manager->read($file->getRealPath());

            // Use toWebp() helper (v3) and save using the .webp extension
            // save() accepts path and quality; the format is derived from extension
            $image->toWebp()->save($absolutePath, $quality);

            // optional: run optimizer (uncomment if you installed spatie/image-optimizer)
            // \Spatie\ImageOptimizer\OptimizerChainFactory::create()->optimize($absolutePath);

            return $relativePath;
        } catch (\Throwable $e) {
            // If conversion fails — fallback: store original file
            // but we log/throw depending on how strict you want to be
            // You can change to throw new Exception($e->getMessage());
            // For practical resilience, fallback to original upload:
            $fallback = $file->store($folder, $disk);
            // Optionally log the original error:
            \Log::warning('WebP conversion failed, stored original file. Error: ' . $e->getMessage());

            return $fallback;
        }
    }
}

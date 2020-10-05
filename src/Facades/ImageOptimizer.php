<?php

namespace Spatie\LaravelImageOptimizer\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Storage;

class ImageOptimizer extends Facade
{
    private static string $storageDisk = "local";

    protected static function getFacadeAccessor()
    {
        return 'image-optimizer';
    }

    public static function optimize(string $pathToImage, string $pathToOutput = null)
    {
        if (file_exists($pathToImage)) {
            parent::optimize($pathToImage, $pathToOutput);

            return;
        }
        if (file_exists(Storage::disk(self::$storageDisk)->path($pathToImage))) {
            if ($pathToOutput !== null) {
                $pathToOutput = Storage::disk(self::$storageDisk)->path($pathToOutput);
            }
            parent::optimize(Storage::disk(self::$storageDisk)->path($pathToImage), $pathToOutput);

            return;
        }

        throw new InvalidArgumentException("`{$pathToImage}` does not exist");
    }

    public static function disk(string $disk)
    {
        self::$storageDisk = $disk;

        return new static;
    }
}

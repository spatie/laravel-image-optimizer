<?php

namespace Spatie\LaravelImageOptimizer\Middlewares;

use Closure;
use Spatie\ImageOptimizer\OptimizerChain;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class OptimizeImages
{
    public function handle($request, Closure $next)
    {
        $optimizerChain = app(OptimizerChain::class);

        collect($request->allFiles())->each(function ($file) use ($optimizerChain) {
            if (is_array($file)) {
                collect($file)->each(function (UploadedFile $one) use ($optimizerChain) {
                    $optimizerChain->optimize($one->getPathname());
                });
            } else {
                $optimizerChain->optimize($file->getPathname());
            }
        });

        return $next($request);
    }
}

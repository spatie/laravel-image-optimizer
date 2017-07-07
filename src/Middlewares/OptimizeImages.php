<?php

namespace Spatie\LaravelImageOptimizer\Middlewares;

use Closure;
use Spatie\ImageOptimizer\OptimizerChain;

class OptimizeImages
{
    public function handle($request, Closure $next)
    {
        $optimizerChain = app(OptimizerChain::class);

        collect($request->allFiles())->each(function ($file) use ($optimizerChain) {
            $optimizerChain->optimize($file);
        });

        return $next($request);
    }
}

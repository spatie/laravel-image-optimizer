<?php

namespace Spatie\LaravelImageOptimizer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getOptimizers()
 * @method static \Spatie\ImageOptimizer\OptimizerChain addOptimizer(\Spatie\ImageOptimizer\Optimizer $optimizer)
 * @method static \Spatie\ImageOptimizer\OptimizerChain setOptimizers(array $optimizers)
 * @method static \Spatie\ImageOptimizer\OptimizerChain setTimeout(int $timeoutInSeconds)
 * @method static \Spatie\ImageOptimizer\OptimizerChain useLogger(\Psr\Log\LoggerInterface $log)
 * @method static void optimize(string $pathToImage, string|null $pathToOutput = null)
 *
 * @see \Spatie\ImageOptimizer\OptimizerChain
 */
class ImageOptimizer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'image-optimizer';
    }
}

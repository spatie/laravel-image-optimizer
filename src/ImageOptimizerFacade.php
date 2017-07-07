<?php

namespace Spatie\LaravelImageOptimizer;

use Illuminate\Support\Facades\Facade;

class ImageOptimizerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'image-optimizer';
    }
}

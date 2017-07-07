<?php

namespace Spatie\LaravelImageOptimizer;

use Illuminate\Support\Facades\Facade;

class LaravelImageOptimizerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'image-optimizer';
    }
}

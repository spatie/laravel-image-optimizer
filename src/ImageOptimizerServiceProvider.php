<?php

namespace Spatie\LaravelImageOptimizer;

use Illuminate\Support\ServiceProvider;
use Spatie\ImageOptimizer\OptimizerChain;

class ImageOptimizerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/image-optimizer.php' => config_path('image-optimizer.php'),
            ], 'config');
        }

        $this->app(OptimizerChain::class, function () {

            return OptimizerChainFactory::create(config('laravel-optimizer'));

        });

        $this->app->singleton('image-optimizer', ResponseCache::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/image-optimizer.php.php', 'image-optimizer');
    }
}

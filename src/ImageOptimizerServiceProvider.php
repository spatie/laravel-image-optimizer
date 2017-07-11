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
                __DIR__.'/../config/image-optimizer.php' => config_path('image-optimizer.php'),
            ], 'config');
        }

        $this->app->bind(OptimizerChain::class, function () {
            return OptimizerChainFactory::create(config('image-optimizer'));
        });

        $this->app->singleton('image-optimizer', OptimizerChain::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/image-optimizer.php', 'image-optimizer');
    }
}

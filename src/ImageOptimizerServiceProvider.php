<?php

namespace Spatie\LaravelImageOptimizer;

use Illuminate\Support\ServiceProvider;
use Spatie\ImageOptimizer\OptimizerChain;
use Laravel\Lumen\Application as LumenApplication;
use Illuminate\Foundation\Application as LaravelApplication;

class ImageOptimizerServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/image-optimizer.php', 'image-optimizer');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/image-optimizer.php' => config_path('image-optimizer.php'),
            ], 'config');
        }

        if ($this->app instanceof LumenApplication) {
            $this->app->configure('image-optimizer');
        }

        $this->app->bind(OptimizerChain::class, function () {
            return OptimizerChainFactory::create(config('image-optimizer'));
        });

        $this->app->singleton('image-optimizer', OptimizerChain::class);
    }
}

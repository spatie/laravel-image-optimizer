<?php

use Spatie\ImageOptimizer\Optimizers\Svgo;
use Spatie\ImageOptimizer\Optimizers\Optipng;
use Spatie\ImageOptimizer\Optimizers\Gifsicle;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;

return [
    'optimizers' => [
        Jpegoptim::class => ['--strip-all', '--all-progressive'],
        Pngquant::class => ['--force'],
        Optipng::class => ['-i0', '-o2', '-quiet'],
        Svgo::class => ['--disable=cleanupIDs'],
        Gifsicle::class => ['-b', '-O3'],
    ],

    'timeout' => 60,

    'logOptimizerActivity' => false,
];

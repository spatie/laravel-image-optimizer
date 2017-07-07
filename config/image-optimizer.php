<?php

use Spatie\ImageOptimizer\Optimizers\Gifsicle;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;
use Spatie\ImageOptimizer\Optimizers\Optipng;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Spatie\ImageOptimizer\Optimizers\Svgo;

return [
    'optimizers' => [

        Jpegoptim::class => [
            '--stip-all',
            '--all-progressive'
        ],

        Pngquant::class => [
            '--force',
        ],
        Optipng::class => [
            '-i0',
            '-o2',
            '-quiet',
        ],
        Svgo::class => [
            '--disable=cleanupIDs',
        ],
        Gifsicle::class => [
            '-b',
            '-O3',
        ],
    ],

    'timout' => 60,

    'logOptimizerActivity' => false,
];

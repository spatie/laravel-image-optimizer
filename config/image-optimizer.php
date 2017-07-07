<?php

return [
    'optimizers' => [
        \Spatie\ImageOptimizer\Optimizers\Jpegoptim::class => [
            '--bla',
            '--bla2'
        ],
    ],

    'timout' => 60,

    'logOptimizerActivity' => false,
];
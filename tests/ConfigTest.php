<?php

namespace Spatie\LaravelImageOptimizer\Test;

use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\LaravelImageOptimizer\Exceptions\InvalidConfiguration;
use stdClass;

class ConfigTest extends TestCase
{
    /** @test */
    public function it_has_a_valid_default_configuration()
    {
        $this->assertInstanceOf(OptimizerChain::class, app(OptimizerChain::class));
    }

    /** @test */
    public function it_will_throw_an_exception_with_a_malconfigured_logger()
    {
        config()->set('image-optimizer.logOptimizerActivity', stdClass::class);

        $this->expectException(InvalidConfiguration::class);

        app(OptimizerChain::class);
    }

    /** @test */
    public function it_will_throw_an_exception_with_a_malconfigured_optimizer()
    {
        config()->set('image-optimizer.optimizers', [stdClass::class => []]);

        $this->expectException(InvalidConfiguration::class);

        app(OptimizerChain::class);
    }
}
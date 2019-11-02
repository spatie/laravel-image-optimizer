<?php

namespace Spatie\LaravelImageOptimizer\Test;

use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\LaravelImageOptimizer\Exceptions\InvalidConfiguration;
use stdClass;

class ImageOptimizerTest extends TestCase
{
    /** @test */
    public function it_has_a_valid_default_configuration()
    {
        $this->assertInstanceOf(OptimizerChain::class, app(OptimizerChain::class));
    }

    /** @test */
    public function it_will_throw_an_exception_with_a_malconfigured_logger()
    {
        config()->set('image-optimizer.log_optimizer_activity', stdClass::class);

        $this->expectException(InvalidConfiguration::class);

        app(OptimizerChain::class);
    }

    /** @test */
    public function it_can_log_to_the_default_log()
    {
        config()->set('image-optimizer.log_optimizer_activity', true);

        $logWriter = new ArrayLogger();

        $this->app->bind('log', function () use ($logWriter) {
            return $logWriter;
        });

        app(OptimizerChain::class)->optimize(
            $this->getImagePath('logo.png'),
            $this->getTempPath('logo.png')
        );

        $this->assertStringContainsString('Start optimizing', $logWriter->getAllLinesAsString());
    }

    /** @test */
    public function it_will_throw_an_exception_with_a_malconfigured_optimizer()
    {
        config()->set('image-optimizer.optimizers', [stdClass::class => []]);

        $this->expectException(InvalidConfiguration::class);

        app(OptimizerChain::class);
    }
}

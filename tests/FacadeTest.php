<?php

namespace Spatie\LaravelImageOptimizer\Test;

use ImageOptimizer;

class FacadeTest extends TestCase
{
    /** @test */
    public function it_has_a_facade()
    {
        $testImagePath = $this->getImagePath('logo.png');

        $destinationPath = $this->getTempPath('logo.png');

        ImageOptimizer::optimize($testImagePath, $destinationPath);

        $this->assertDecreasedFileSize($destinationPath, $testImagePath);
    }
}

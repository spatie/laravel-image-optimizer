<?php

namespace Spatie\LaravelImageOptimizer\Test;

use ImageOptimizer;

class FacadeTest extends TestCase
{
    /** @test */
    public function it_has_a_facade()
    {
        $testImagePath = $this->imagePath('logo.png');

        $destinationPath = $this->destinationPath('logo.png');

        ImageOptimizer::optimize($testImagePath, $destinationPath);

        $this->assertDecreasedFileSize($destinationPath, $testImagePath);

    }
}
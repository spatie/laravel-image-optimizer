<?php

namespace Spatie\LaravelImageOptimizer\Test;

use PHPUnit\Framework\Attributes\Test;
use ImageOptimizer;

class FacadeTest extends TestCase
{
        #[Test]
    public function it_has_a_facade()
    {
        $testImagePath = $this->getImagePath('logo.png');

        $destinationPath = $this->getTempPath('logo.png');

        ImageOptimizer::optimize($testImagePath, $destinationPath);

        $this->assertDecreasedFileSize($destinationPath, $testImagePath);
    }
}

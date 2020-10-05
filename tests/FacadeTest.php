<?php

namespace Spatie\LaravelImageOptimizer\Test;

use Illuminate\Support\Facades\Storage;
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

    /** @test */
    public function it_can_wrap_a_path_to_image_in_storage_facade_path()
    {
        Storage::fake('photos');

        $path = str_replace(__DIR__, "", $this->getImagePath('logo.png'));

        Storage::disk('photos')->put($path, file_get_contents($this->getImagePath('logo.png')));

        ImageOptimizer::disk('photos')
            ->optimize($path);

        $this->assertDecreasedFileSize(Storage::disk('photos')->path($path), $this->getImagePath('logo.png'));
    }
}

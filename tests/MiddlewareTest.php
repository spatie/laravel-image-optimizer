<?php

namespace Spatie\LaravelImageOptimizer\Test;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelImageOptimizer\Middlewares\OptimizeImages;

class MiddlewareTest extends TestCase
{
    /** @test */
    public function it_will_try_to_optimize_all_files_in_a_request()
    {
        $originalImagePath = $this->getImagePath('logo.png');

        $uploadPath = $this->getTempPath('logo.png');

        copy($originalImagePath, $uploadPath);

        Route::middleware(OptimizeImages::class)->post('/', function () {
        });

        $this->call('POST', '/', [], [], ['upload' => $this->getUploadFile($uploadPath)]);

        $this->assertDecreasedFileSize($uploadPath, $originalImagePath);
    }

    protected function getUploadFile(string $path): UploadedFile
    {
        return new UploadedFile(
            $path,
            pathinfo($path, PATHINFO_BASENAME),
            mime_content_type($path),
            filesize($path)
        );
    }
}

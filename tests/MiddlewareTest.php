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

    /** @test */
    public function it_will_optimize_all_files_at_all_depths()
    {
        $originalImagePath1 = $this->getImagePath('logo.png');
        $uploadPath1 = $this->getTempPath('logo.png');

        $originalImagePath2 = $this->getImagePath('logo2.png');
        $uploadPath2 = $this->getTempPath('logo2.png');

        $originalImagePath3 = $this->getImagePath('logo3.png');
        $uploadPath3 = $this->getTempPath('logo3.png');

        copy($originalImagePath1, $uploadPath1);
        copy($originalImagePath2, $uploadPath2);
        copy($originalImagePath3, $uploadPath3);

        Route::middleware(OptimizeImages::class)->post('/', function () {
        });

        $this->call('POST', '/', [], [], [
            'upload' => $this->getUploadFile($uploadPath1),
            'one' => [
                'two' => $this->getUploadFile($uploadPath2),
                'three' => [
                    'four' => $this->getUploadFile($uploadPath3),
                ],
            ],
        ]);

        $this->assertDecreasedFileSize($uploadPath1, $originalImagePath1);
        $this->assertDecreasedFileSize($uploadPath2, $originalImagePath2);
        $this->assertDecreasedFileSize($uploadPath3, $originalImagePath3);
    }

    protected function getUploadFile(string $path): UploadedFile
    {
        return new UploadedFile(
            $path,
            pathinfo($path, PATHINFO_BASENAME),
            mime_content_type($path),
            filesize($path),
            true
        );
    }
}

<?php

namespace Spatie\LaravelImageOptimizer\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Spatie\LaravelImageOptimizer\ImageOptimizerServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->emptyTempDirectory();
    }

    protected function getPackageProviders($app)
    {
        return [
            ImageOptimizerServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'ImageOptimizer' => \Spatie\LaravelImageOptimizer\Facades\ImageOptimizer::class,
        ];
    }

    protected function emptyTempDirectory()
    {
        $tempDirPath = __DIR__.'/temp';

        $files = scandir($tempDirPath);

        foreach ($files as $file) {
            if (! in_array($file, ['.', '..', '.gitignore'])) {
                unlink("{$tempDirPath}/{$file}");
            }
        }
    }

    protected function getImagePath(string $path): string
    {
        return __DIR__."/testfiles/{$path}";
    }

    protected function getTempPath(string $path): string
    {
        return __DIR__."/temp/{$path}";
    }

    protected function assertDecreasedFileSize(string $modifiedFilePath, string $originalFilePath)
    {
        $this->assertFileExists($originalFilePath);

        $this->assertFileExists($modifiedFilePath);

        $originalFileSize = filesize($originalFilePath);

        $modifiedFileSize = filesize($modifiedFilePath);

        $this->assertTrue($modifiedFileSize < $originalFileSize,
            "File {$modifiedFilePath} as size {$modifiedFileSize} which is not less than {$originalFileSize}"
        );

        $this->assertTrue($modifiedFileSize > 0, "File {$modifiedFilePath} had a filesize of zero. Something must have gone wrong...");
    }
}

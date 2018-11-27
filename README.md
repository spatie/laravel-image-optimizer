# Optimize images in your Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-image-optimizer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-image-optimizer)
[![Build Status](https://img.shields.io/travis/spatie/laravel-image-optimizer/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-image-optimizer)
[![StyleCI](https://styleci.io/repos/96563589/shield?branch=master)](https://styleci.io/repos/96563589)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-image-optimizer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-image-optimizer)

This package is the Laravel 5.4 and up specific integration of [spatie/image-optimizer](https://github.com/spatie/image-optimizer). It can optimize PNGs, JPGs, SVGs and GIFs by running them through a chain of various [image optimization tools](https://github.com/spatie/image-optimizer#optimization-tools). The package will automatically detect which optimization binaries are installed on your system and use them.

Here's how you can use it:

```php
use ImageOptimizer;

// the image will be replaced with an optimized version which should be smaller
ImageOptimizer::optimize($pathToImage);

// if you use a second parameter the package will not modify the original
ImageOptimizer::optimize($pathToImage, $pathToOptimizedImage);
```

You don't like facades you say? No problem! Just resolve a configured instance of `Spatie\ImageOptimizer\OptimizerChain` out of the container:

```php
app(Spatie\ImageOptimizer\OptimizerChain::class)->optimize($pathToImage);
```

The package also contains [a middleware](https://github.com/spatie/laravel-image-optimizer/blob/master/README.md#using-the-middleware) to automatically optimize all images in an request.

Don't use Laravel you say? No problem! Just use the underlying [spatie/image-optimizer](https://github.com/spatie/image-optimizer) directly.

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-image-optimizer
```

The package will automatically register itself.

The package uses a bunch of binaries to optimize images. To learn which ones on how to install them, head over to the [optimization tools section](https://github.com/spatie/image-optimizer#optimization-tools) in the readme of the underlying image-optimizer package. That readme also contains info on [what these tools will do to your images](https://github.com/spatie/image-optimizer#which-tools-will-do-what).

The package comes with some sane defaults to optimize images. You can modify that configuration by publishing the config file.

```bash
php artisan vendor:publish --provider="Spatie\LaravelImageOptimizer\ImageOptimizerServiceProvider"
```

This is the contents of the `config/image-optimizer` file that will be published:

```php
use Spatie\ImageOptimizer\Optimizers\Svgo;
use Spatie\ImageOptimizer\Optimizers\Optipng;
use Spatie\ImageOptimizer\Optimizers\Gifsicle;
use Spatie\ImageOptimizer\Optimizers\Pngquant;
use Spatie\ImageOptimizer\Optimizers\Jpegoptim;

return [
    /**
     * When calling `optimize` the package will automatically determine which optimizers
     * should run for the given image.
     */
    'optimizers' => [

        Jpegoptim::class => [
            '-m85', // set maximum quality to 85%
            '--strip-all',  // this strips out all text information such as comments and EXIF data
            '--all-progressive'  // this will make sure the resulting image is a progressive one
        ],

        Pngquant::class => [
            '--force' // required parameter for this package
        ],

        Optipng::class => [
            '-i0', // this will result in a non-interlaced, progressive scanned image
            '-o2',  // this set the optimization level to two (multiple IDAT compression trials)
            '-quiet' // required parameter for this package
        ],

        Svgo::class => [
            '--disable=cleanupIDs' // disabling because it is know to cause troubles
        ],

        Gifsicle::class => [
            '-b', // required parameter for this package
            '-O3' // this produces the slowest but best results
        ],
    ],

    /**
     * The maximum time in seconds each optimizer is allowed to run separately.
     */
    'timeout' => 60,

    /**
     * If set to `true` all output of the optimizer binaries will be appended to the default log.
     * You can also set this to a class that implements `Psr\Log\LoggerInterface`.
     */
    'log_optimizer_activity' => false,
];
```

If you want to automatically optimize images that get uploaded to your application add the `\Spatie\LaravelImageOptimizer\Middlewares\OptimizeImages::class` in the http kernel.

```php
// app/Http/Kernel.php
protected $routeMiddleware = [
   ...
   'optimizeImages' => \Spatie\LaravelImageOptimizer\Middlewares\OptimizeImages::class,
];
```

## Usage

You can resolve a configured instance of `Spatie\ImageOptimizer\OptimizerChain` out of the container:

```php
// the image will be replaced with an optimized version which should be smaller
app(Spatie\ImageOptimizer\OptimizerChain::class)->optimize($pathToImage);

// if you use a second parameter the package will not modify the original
app(Spatie\ImageOptimizer\OptimizerChain::class)->optimize($pathToImage, $pathToOptimizedImage);
```

### Using the facade

```php
use ImageOptimizer;

// the image will be replaced with an optimized version which should be smaller
ImageOptimizer::optimize($pathToImage);

// if you use a second parameter the package will not modify the original
ImageOptimizer::optimize($pathToImage, $pathToOptimizedImage);
```

You don't like facades you say? No problem! Just resolve a configured instance of `Spatie\ImageOptimizer\OptimizerChain` out of the container:

```php
app(Spatie\ImageOptimizer\OptimizerChain::class)->optimize($pathToImage);
```

### Using the middleware

All images that in requests to routes that use the `optimizeImages`-middleware will be optimized automatically.

```php
Route::middleware('optimizeImages')->group(function () {
    // all images will be optimized automatically
    Route::post('upload-images', 'UploadController@index');
});
```

### Adding your own optimizers

To learn how to create your own optimizer read the ["Writing custom optimizers" section](https://github.com/spatie/image-optimizer#writing-a-custom-optimizers) in the readme of the underlying [spatie/image-optimizer](https://github.com/spatie/image-optimizer#writing-a-custom-optimizers) package.

You can add the fully qualified classname of your optimizer as a key in the `optimizers` array in the config file.

## Example conversions

Here are some [example conversions](https://github.com/spatie/image-optimizer#example-conversions) that were made by the optimizer.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

The idea of a middleware that optimizes all files in a request is taken from [approached/laravel-image-optimizer](https://github.com/approached/laravel-image-optimizer).

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

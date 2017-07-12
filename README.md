**WORK IN PROGRESS DO NOT USE YET**

# Optimize images in your Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-image-optimizer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-image-optimizer)
[![Build Status](https://img.shields.io/travis/spatie/laravel-image-optimizer/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-image-optimizer)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/99e8ebe7-8c77-44e9-b5c3-a4c5f73b2c30.svg?style=flat-square)](https://insight.sensiolabs.com/projects/99e8ebe7-8c77-44e9-b5c3-a4c5f73b2c30)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-image-optimizer.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-image-optimizer)
[![StyleCI](https://styleci.io/repos/96563589/shield?branch=master)](https://styleci.io/repos/96563589)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-image-optimizer.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-image-optimizer)

This package is the laravel specific integration of [spatie/image-optimizer](https://github.com/spatie/image-optimizer). It can optimize PNGs, JPGs, SVGs and GIFs by running them through a chain of various [image optimization tools](#optimization-tools). The package will automatically detect which optimization binaries are installed on your system and use them.

 Here's how you can use it:

```php
use ImageOptimizer;

//the image will be replace with an optimized version which should be smaller
ImageOptimizer::optimize($pathToImage);

//if you use a second parameter the package will not modify the original
ImageOptimizer::optimize($pathToImage, $pathToOptimizedImage);
```

You don't like facades you say? No problem! Just resolve a configured instance of `Spatie\ImageOptimizer\OptimizerChain` out of the container:

```php
app(Spatie\ImageOptimizer\OptimizerChain::class)->optimize($pathToImage);
```

Don't use Laravel you say? No problem! Just use the underlying [spatie/image-optimizer](https://github.com/spatie/image-optimizer) directly.

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/laravel-image-optimizer
```

## Usage

``` php
$skeleton = new Spatie\LaravelImageOptimizer();
echo $skeleton->echoPhrase('Hello, Spatie!');
```

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

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## About Spatie

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

<?php

namespace Spatie\LaravelImageOptimizer;

use Psr\Log\LoggerInterface;
use Spatie\ImageOptimizer\Optimizer;
use Spatie\ImageOptimizer\DummyLogger;
use Spatie\ImageOptimizer\OptimizerChain;
use Spatie\LaravelImageOptimizer\Exceptions\InvalidConfiguration;

class OptimizerChainFactory
{
    public static function create(array $config)
    {
        return (new OptimizerChain())
            ->useLogger(static::getLogger($config))
            ->setTimeout($config['timeout'])
            ->setOptimizers(static::getOptimizers($config));
    }

    protected static function getLogger($config): LoggerInterface
    {
        $configuredLogger = $config['log_optimizer_activity'];

        if ($configuredLogger === true) {
            return app('log');
        }

        if ($configuredLogger === false) {
            return new DummyLogger();
        }

        if (! $configuredLogger instanceof LoggerInterface) {
            throw InvalidConfiguration::notAnLogger($configuredLogger);
        }

        return new $configuredLogger;
    }

    protected static function getOptimizers(array $config)
    {
        return collect($config['optimizers'])
          ->mapWithKeys(function (array $options, string $optimizerClass) use ($config) {
              if (! is_a($optimizerClass, Optimizer::class, true)) {
                  throw InvalidConfiguration::notAnOptimizer($optimizerClass);
              }

              // Initialize optimizer class
              $newOptimizerClass = new $optimizerClass();

              if (self::binaryPath($config)) {
                  $newOptimizerClass->setBinaryPath(self::binaryPath($config));
              }

              $newOptimizerClass->setOptions($options);

              return [$optimizerClass => $newOptimizerClass];
          })
          ->toArray();
    }

    /**
     * Chek whether binary path has been defined in config.
     *
     * @param array $config
     * @return string
     */
    public function binaryPath($config)
    {
        if (isset($config['binary_path']) && $config['binary_path']) {
            return $config['binary_path'];
        }

        return '';
    }
}

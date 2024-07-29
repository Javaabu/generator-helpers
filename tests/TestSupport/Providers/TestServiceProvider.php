<?php

namespace Javaabu\GeneratorHelpers\Tests\TestSupport\Providers;

use Illuminate\Support\ServiceProvider;
use Javaabu\GeneratorHelpers\StubRenderer;
use Javaabu\GeneratorHelpers\Tests\TestSupport\Commands\FactoryGenerateCommand;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom([
            __DIR__ . '/../database',
        ]);

        StubRenderer::loadStubsFrom(__DIR__ . '/../stubs', 'generator_helpers_tests');

        $this->commands([
            FactoryGenerateCommand::class,
        ]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {

    }
}

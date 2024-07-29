<?php

namespace Javaabu\GeneratorHelpers\Tests;

use Javaabu\GeneratorHelpers\Testing\InteractsWithTestFiles;
use Javaabu\GeneratorHelpers\Testing\InteractsWithTestStubs;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Javaabu\GeneratorHelpers\GeneratorHelpersServiceProvider;
use Javaabu\GeneratorHelpers\Tests\TestSupport\Providers\TestServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use InteractsWithTestFiles;
    use InteractsWithTestStubs;

    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.key', 'base64:yWa/ByhLC/GUvfToOuaPD7zDwB64qkc/QkaQOrT5IpE=');

        $this->app['config']->set('session.serialization', 'php');

        $this->loadTestStubsFrom(__DIR__ . '/TestSupport/test-stubs');

    }

    protected function getPackageProviders($app)
    {
        return [
            GeneratorHelpersServiceProvider::class,
            TestServiceProvider::class
        ];
    }
}

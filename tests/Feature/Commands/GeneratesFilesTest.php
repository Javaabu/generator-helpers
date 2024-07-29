<?php

namespace Javaabu\GeneratorHelpers\Tests\Feature\Commands;

use Illuminate\Filesystem\Filesystem;
use Javaabu\GeneratorHelpers\Tests\TestCase;
use Mockery\MockInterface;

class GeneratesFilesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->deleteFile($this->app->databasePath('factories/CategoryFactory.php'));
    }

    protected function tearDown(): void
    {
        $this->deleteFile($this->app->databasePath('factories/CategoryFactory.php'));

        parent::tearDown();
    }

    /** @test */
    public function it_can_generate_a_new_file(): void
    {
        $expected_path = $this->app->databasePath('factories/CategoryFactory.php');
        $expected_content = $this->getTestStubContents('factories/CategoryFactory.php');

        $this->artisan('generator_helpers:factory', ['table' => 'categories', '--create' => true])
            ->assertSuccessful();

        $this->assertFileExists($expected_path);

        $actual_content = $this->getGeneratedFileContents($expected_path);
        $this->assertEquals($expected_content, $actual_content);
    }

    /** @test */
    public function it_does_not_create_existing_files_without_the_force_option(): void
    {
        $expected_path = $this->app->databasePath('factories/CategoryFactory.php');

        $this->partialMock(Filesystem::class, function (MockInterface $mock) {
            $mock->shouldReceive('exists')
                ->once()
                ->andReturnTrue();

            $mock->shouldNotReceive('makeDirectory');

            $mock->shouldNotReceive('put');
        });

        $this->artisan('generator_helpers:factory', ['table' => 'categories', '--create' => true])
            ->expectsOutput($expected_path . ' already exists!');
    }

    /** @test */
    public function it_over_writes_existing_files_with_the_force_option(): void
    {
        $this->partialMock(Filesystem::class, function (MockInterface $mock) {
            $mock->shouldReceive('exists')
                ->once()
                ->andReturnTrue();

            $mock->shouldReceive('makeDirectory')
                ->andReturnTrue();

            $mock->shouldReceive('put')
                ->once()
                ->andReturnTrue();
        });

        $this->artisan('generator_helpers:factory', ['table' => 'categories', '--create' => true, '--force' => true])
            ->assertSuccessful();
    }
}

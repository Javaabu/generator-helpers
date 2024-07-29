---
title: Testing
sidebar_position: 4
---

You can use the `InteractsWithTestFiles` and the `InteractsWithTestStubs` traits in your tests.

```php
use Javaabu\GeneratorHelpers\Testing\InteractsWithTestFiles;
use Javaabu\GeneratorHelpers\Testing\InteractsWithTestStubs;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use InteractsWithTestFiles;
    use InteractsWithTestStubs; 
...
```

## Defining where to load your test stubs from

In your test case `setup` method, you can call the `loadTestStubsFrom` method.

```php
...
public function setUp(): void
{
    parent::setUp();
   
    $this->loadTestStubsFrom(__DIR__ . '/TestSupport/test-stubs');

}
...
```

## Comparing generated content with expect content

```php
/** @test */
public function it_can_replace_multiple_names(): void
{
    $renderer = $this->getRenderer();

    $expected_content = $this->getTestStubContents('MultipleNameCases.php');
    $actual_content = $renderer->replaceFileNames($this->getTestStubPath('NameCases.stub'), 'form_input_field');

    $this->assertEquals($expected_content, $actual_content);
}
```

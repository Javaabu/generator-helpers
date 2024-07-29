---
title: Stub Renderer
sidebar_position: 1
---

The `StubRenderer` class is used to load, replace and append content to stub files.

## Using stubs in a package

In your package service provider's `boot` method, define the path from where you load your stubs and register your publishes for stubs.

```php
use Javaabu\GeneratorHelpers\StubRenderer;

...
public function boot()
{
    if ($this->app->runningInConsole()) {           
        $this->publishes([
            __DIR__ . '/../stubs' => base_path('stubs/vendor/your-package'),
        ], 'your-package-stubs');
    }

    StubRenderer::loadStubsFrom(__DIR__ . '/../stubs', 'your-package');  
}
...
```

Now you can load your stubs using the `StubRenderer` class.

```php
use Javaabu\GeneratorHelpers\StubRenderer;

$renderer = app()->make(StubRenderer::class);
$stub_contents = $renderer->loadStub('your-package::Models/Model.stub'); // stub file at /your-package/stubs/Models/Model.stub
```

## Available Methods

The `StubRenderer` class offers several helpful methods.

### getFileContents

Returns the file contents of a given file.

```php
$renderer->getFileContents('/path/to/file.php');
```

### replaceStubNames

Loads the given stub and replace the placeholders in the stub with the given name.

```php
$renderer->replaceStubNames('your-package::Models/Model.stub', 'form_input_field');

/**
// performs the following replacements for the 
// following supported placeholders
{{name}} -> form_input_field
{{camel}} -> formInputField
{{kebab}} -> form-input-field
{{snake}} -> form_input_field
{{studly}} -> FormInputField
{{title}} -> Form Input Field
{{lower}} -> form input field
{{pluralCamel}} -> formInputFields
{{pluralKebab}} -> form-input-fields
{{pluralSnake}} -> form_input_fields
{{pluralStudly}} -> FormInputFields
{{pluralTitle}} -> Form Input Fields
{{pluralLower}} -> form input fields
{{singularCamel}} -> formInputField
{{singularKebab}} -> form-input-field
{{singularSnake}} -> form_input_field
{{singularStudly}} -> FormInputField
{{singularTitle}} -> Form Input Field
{{singularLower}} -> form input field
 */
```

You can also call the `replaceStubNames` method with an optional suffix. This can be useful when a stub has multiple names that need to be replaced. When using a suffix, the renderer will only replace placeholders that has the specific suffix.

```php
$rendered_content = $renderer->replaceStubNames('your-package::Models/Model.stub', 'form_input_field', 'Model');

/**
// performs the following replacements for the 
// following supported placeholders
{{nameModel}} -> form_input_field
{{camelModel}} -> formInputField
{{kebabModel}} -> form-input-field
{{snakeModel}} -> form_input_field
{{studlyModel}} -> FormInputField
{{titleModel}} -> Form Input Field
{{lowerModel}} -> form input field
{{pluralCamelModel}} -> formInputFields
{{pluralKebabModel}} -> form-input-fields
{{pluralSnakeModel}} -> form_input_fields
{{pluralStudlyModel}} -> FormInputFields
{{pluralTitleModel}} -> Form Input Fields
{{pluralLowerModel}} -> form input fields
{{singularCamelModel}} -> formInputField
{{singularKebabModel}} -> form-input-field
{{singularSnakeModel}} -> form_input_field
{{singularStudlyModel}} -> FormInputField
{{singularTitleModel}} -> Form Input Field
{{singularLowerModel}} -> form input field
 */
```

### replaceFileNames

This method is similar to the `replaceStubNames` method. But instead of a namespaced stub name, you've to provide the full file path.

```php
$rendered_content = $renderer->replaceStubNames('your-package/stubs/Models/Model.stub', 'form_input_field', 'Model');
```

### loadStub

Returns the content of the given stub.

```php
$stub_contents = $renderer->loadStub('your-package::Models/Model.stub');
```

### resolveStubPath

Returns the full file path of a namespaced stub.

```php
$stub_path = $renderer->resolveStubPath('your-package::Models/Model.stub');
```

### defaultStubPath

Returns the registered stub path for a given namespace.

```php
$stub_directory = $renderer->defaultStubPath('your-package');
```

### appendToStub

Load a given stub and append content to it by placing the given conent after the given search string.

```php
$rendered_content = $renderer->appendToStub('your-package::Models/Model.stub', 'Content to append', '{{search string}}');
// This will add "Content to append" after {{search string}}
```

If you want to instead replace the search string, you can set the last argument `false`.

```php
$rendered_content = $renderer->appendToStub('your-package::Models/Model.stub', 'Content to append', '{{search string}}', false);
// This will replace {{search string}} with "Content to append"
```

### appendToFile

This is similar to the `appendToStub` method, but you need to provide the full file path instead of a namespaced stub name.

```php
$rendered_content = $renderer->appendToFile('your-package/stubs/Models/Model.stub', 'Content to append', '{{search string}}');
```

### appendContent

Appends content to the given template string at the given search string.

```php
$rendered_content = $renderer->appendContent('Content to append', '{{search string}}', 'Template string {{search string}}', true);
// returns "Template string {{search string}}Content to append"
```

Set the last argument to `false` to replace the search string.

```php
$rendered_content = $renderer->appendContent('Content to append', '{{search string}}', 'Template string {{search string}}', false);
// returns "Template string Content to append"
```

### appendMultipleContent

Similar to the `appendContent` method, but allows doing multiple appends or replacements.

```php
$rendered_content = $renderer->appendMultipleContent(
    [
        [
            'content' => 'Content to append', 
            'search' => '{{search string}}', 
            'keep_search' => false,
            'force' => false,
        ]
    ],    
    'Template string {{search string}}', 
    false
);
// returns "Template string Content to append"
```

You can set the last argument to `true` to skip appending any existing content in the template.

```php
$rendered_content = $renderer->appendMultipleContent(
    [
        [
            'content' => 'Content to append', 
            'search' => '{{search string}}', 
            'keep_search' => false,
            'force' => false,
        ]
    ],    
    'Content to append Template string {{search string}}', 
    true
);
// returns "Content to append Template string {{search string}}"
```

You can override this for specific content by setting the `force` option to `false` for that content.

```php
$rendered_content = $renderer->appendMultipleContent(
    [
        [
            'content' => 'Content to append', 
            'search' => '{{search string}}', 
            'keep_search' => false,
            'force' => true,
        ]
    ],    
    'Content to append Template string {{search string}}', 
    true
);
// returns "Content to append Template string Content to append"
```

### addIndentation

Adds the given number of indents to the given template string.

```php
$rendered_content = $renderer->addIndentation(
    'Content to indent',    
    2, // number of indents
    4, // how many spaces is each indent (optional)
    ' ', // space character (optional)
    '' // string to match the length (optional)
)
// returns
// "        Content to indent"
```

### replaceNames

Similar to `replaceStubNames`, but used to replace names in a given template string instead of a file.

```php
$rendered_content = $renderer->replaceNames('form_field', '{{camel}} Name');
// returns "formField Name" 
```

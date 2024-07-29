---
title: Using stubs in commands
sidebar_position: 3
---

To use stubs in commands, use the `GeneratesFiles` trait in your command.

```php
use Javaabu\GeneratorHelpers\Concerns\GeneratesFiles;
use Illuminate\Console\Command;

class FactoryGenerateCommand extends Command 
{
    use GeneratesFiles;
  
...
```

## Available Methods

The trait will add the following methods to your command.

- **`getFilesystem()`**: Returns the Laravel Filesystem instance
- **`getRenderer()`**: Returns a `StubRenderer` instance
- **`getFullFilePath(string $path, string $file_name)`**: Returns the full file path with the file name appended to the path.
- **`getPath(string $default, string $path = '')`**: Returns the `default` path if no `path` given. Otherwise, returns the full absolute path relative to the project base path.
- **`appendContent(string $file_path, array $contents, string $stub = '')`**: If the given file exists, appends the given contents to that file using `StubRenderer` `appendMultipleContent` method. Otherwise, creates a new file at the given file path using the given stub and appends the content.
- **`putContent(string $file_path, string $content, bool $force = false)`**: Creates a file at the given file path with the given content. Returns an error if file already exists, unless using the `force` option. When using the `force` option, the file is overwritten.
- **`alreadyExists(string $path)`**: Checks if a given file already exists.
- **`makeDirectory(string $path)`**: Creates a directory at the given path.

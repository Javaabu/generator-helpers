<?php

namespace Javaabu\GeneratorHelpers\Tests\TestSupport\Commands;

use Illuminate\Console\Command;
use Javaabu\GeneratorHelpers\Concerns\GeneratesFiles;
use Javaabu\GeneratorHelpers\StringCaser;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class FactoryGenerateCommand extends Command
{
    use GeneratesFiles;

    protected $name = 'generator_helpers:factory';

    protected $description = 'Generate model factory based on your database table schema';

    /** @return array */
    protected function getArguments()
    {
        return [
            ['table', InputArgument::REQUIRED, 'The table of which you want to generate from']
        ];
    }

    /** @return array */
    protected function getOptions()
    {
        return [
            ['columns', null, InputOption::VALUE_REQUIRED, 'Only generate for specific columns of the table', ''],
            ['create', 'c', InputOption::VALUE_NONE, 'Instead of outputting the generated code, create actual files'],
            ['force', 'f', InputOption::VALUE_NONE, 'If "create" was given, then the files gets created even if they already exists'],
            ['path', 'p', InputOption::VALUE_REQUIRED, 'Specify the path to create the files'],
        ];
    }

    public function handle(): int
    {
        // Arguments
        $force = (bool) $this->option('force');
        $table = (string) $this->argument('table');

        $path = $this->getPath(database_path('factories'), '');

        $file_name = StringCaser::singularStudly($table) . 'Factory.php';
        $file_path = $this->getFullFilePath($path, $file_name);

        $output = $this->getRenderer()->replaceStubNames('generator_helpers_tests::factories/ModelFactory.stub', $table);

        if ($this->putContent($file_path, $output, $force)) {
            $this->info("$file_name created!");
        }

        return Command::SUCCESS;
    }
}

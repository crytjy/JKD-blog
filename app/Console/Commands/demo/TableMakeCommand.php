<?php

namespace App\Console\Commands\demo;

use Illuminate\Console\GeneratorCommand;

class TableMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:jkd-table';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new table';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'JKDTable';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/table.stub';
    }


    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }

}
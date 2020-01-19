<?php

namespace App\Console\Commands\demo;

use Illuminate\Console\GeneratorCommand;

class JsMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:jkd-js';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new js';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'JKDJs';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/js.stub';
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
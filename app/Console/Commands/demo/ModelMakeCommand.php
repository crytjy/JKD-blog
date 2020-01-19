<?php

namespace App\Console\Commands\demo;

use Illuminate\Console\GeneratorCommand;

class ModelMakeCommand extends GeneratorCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:jkd-model';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model class';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'JKDModel';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/model.stub';
    }


    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
    }

}
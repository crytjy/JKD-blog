<?php

namespace Illuminate\Console;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

abstract class GeneratorCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type;

    /**
     * Create a new controller creator command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    abstract protected function getStub();

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        // First we will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.
        if ((!$this->hasOption('force') ||
            !$this->option('force')) &&
          $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.
        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        $this->info($this->type . ' created successfully.');
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param string $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = str_replace('/', '\\', $name);

        return $this->qualifyClass(
          $this->getDefaultNamespace(trim($rootNamespace, '\\')) . '\\' . $name
        );
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

    /**
     * Determine if the class already exists.
     *
     * @param string $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        return $this->files->exists($this->getPath($this->qualifyClass($rawName)));
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
//
        if ($this->type === 'JKDJs') {
            $path = $this->laravel['path'] . '/../public/js/' . str_replace('\\', '/', $name) . '.js';
        } elseif ($this->type === 'JKDAdd') {
            $path = $this->laravel['path'] . '/../resources/views/' . str_replace('\\', '/', $name) . '/add.blade.php';
        } elseif ($this->type === 'JKDIndex') {
            $path = $this->laravel['path'] . '/../resources/views/' . str_replace('\\', '/', $name) . '/index.blade.php';
        }  elseif ($this->type === 'JKDTable') {
            $path = $this->laravel['path'] . '/../database/migrations/'. date('Y_m_d_') . substr(time(),-6) . '_create_' . str_replace('\\', '/', $name) . '_table.php';
        } else {
            $path = $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . '.php';
        }

        return $path;
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param string $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $DummyNamespace = $this->getNamespace($name);
        $DummyRootNamespace = $this->rootNamespace();
        $NamespacedDummyUserModel = $this->userProviderModel();

        if (strpos($this->type, 'JKD') === false) {
            $nameData = [
              'DummyNamespace',
              'DummyRootNamespace',
              'NamespacedDummyUserModel'
            ];
            $valueData = [
              $DummyNamespace,
              $DummyRootNamespace,
              $NamespacedDummyUserModel
            ];
        } else {
            list($DummyModelPath, $DummyModelClass) = $this->getModelNmae($DummyNamespace, $name);

            if ($this->type === 'JKDAdd' || $this->type === 'JKDIndex') {
                $viewPrefix = explode('\\', $DummyNamespace)[1] ?? '';
            }else {
                $viewPrefix = explode('\\', $DummyNamespace)[3] ?? '';
            }
            $ViewName = strtolower($viewPrefix) . '.' . strtolower($DummyModelClass);
            $postName = explode('Post', $DummyModelClass)[0] ?? '';
            $RoutePrefix = config('jkd.routePrefix') . strtolower($postName);
            $DummyModelName = config('jkd.modelPrefix') . $DummyModelClass;
            list($DummyRequestPath, $DummyRequestName) = $this->getRequestNmae($DummyNamespace, $name, $viewPrefix);
            list($DummyRepositoryPath, $DummyRepositoryName, $RepositoryDummyName) = $this->getRepositoryNmae($DummyNamespace, $name, $viewPrefix);

            $jsPath = '/js/' . $viewPrefix . '/' . $DummyModelClass . '.js';
            $tableClass = 'Create' . $DummyModelClass . 'Table';
            $tableName = $this->changeName($DummyModelClass);

            $nameData = [
              'DummyNamespace',
              'DummyRootNamespace',
              'NamespacedDummyUserModel',
              'DummyRequestPath',
              'DummyRequestName',
              'DummyRepositoryPath',
              'DummyRepositoryName',
              'RepositoryDummyName',
              'ViewName',
              'DummyModelPath',
              'DummyModelClass',
              'DummyModelName',
              'RoutePrefix',
              'jsPath',
              'tableClass',
              'tableName'
            ];
            $valueData = [
              $DummyNamespace,
              $DummyRootNamespace,
              $NamespacedDummyUserModel,
              $DummyRequestPath,
              $DummyRequestName,
              $DummyRepositoryPath,
              $DummyRepositoryName,
              $RepositoryDummyName,
              $ViewName,
              $DummyModelPath,
              $DummyModelClass,
              $DummyModelName,
              $RoutePrefix,
              $jsPath,
              $tableClass,
              $tableName
            ];
        }

        $stub = str_replace($nameData, $valueData, $stub);

        return $this;
    }

    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param string $name
     * @return string
     */
    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }


    /**
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name) . '\\', '', $name);

        return str_replace('DummyClass', $class, $stub);
    }


    protected function getClassPath($DummyNamespace)
    {
        $classPath = str_replace('App\\' . $this->type . '\\', '', $DummyNamespace);

        return $classPath;
    }


    protected function getControllerNmae($DummyNamespace, $name)
    {
        $classPath = $this->getClassPath($DummyNamespace);

        $class = str_replace($DummyNamespace . '\\', '', $name);
        $controllerName = explode($this->type, $class)[0];

        return $classPath . '\\' . $controllerName . 'Controller';
    }


    /**
     * get repository name
     *
     * @param $DummyNamespace
     * @param $name
     * @param $viewPrefix
     * @return array
     */
    protected function getRepositoryNmae($DummyNamespace, $name, $viewPrefix)
    {
        $classPath = $this->getClassPath($DummyNamespace);

        $class = str_replace($DummyNamespace . '\\', '', $name);
        $repositoryName = explode($this->type, $class)[0];
        $repositoryName = explode('Controller', $repositoryName)[0] ?? $repositoryName;
        $repositoryName = explode('Repository', $repositoryName)[0] ?? $repositoryName;

        return [config('jkd.repositoryPathPrefix') . $viewPrefix . '\\' . $repositoryName . 'Repository', $repositoryName . 'Repository', config('jkd.repositoryPrefix') . $repositoryName];
    }


    /**
     * get request name
     *
     * @param $DummyNamespace
     * @param $name
     * @param $viewPrefix
     * @return array
     */
    protected function getRequestNmae($DummyNamespace, $name, $viewPrefix)
    {
        $classPath = $this->getClassPath($DummyNamespace);

        $class = str_replace($DummyNamespace . '\\', '', $name);
        $requestName = explode($this->type, $class)[0];
        $requestName = explode('Controller', $requestName)[0] ?? $requestName;
        $requestName = explode('Repository', $requestName)[0] ?? $requestName;

        return ['App\\Http\\Requests\\' . $viewPrefix . '\\' . $requestName . config('jkd.requestSuffix'), $requestName . config('jkd.requestSuffix')];
    }


    /**
     * get model name
     *
     * @param $DummyNamespace
     * @param $name
     * @return array
     */
    protected function getModelNmae($DummyNamespace, $name)
    {
        $class = str_replace($DummyNamespace . '\\', '', $name);
        $modelName = explode($this->type, $class)[0];
        $modelName = explode('Controller', $modelName)[0] ?? $modelName;
        $modelName = explode('Repository', $modelName)[0] ?? $modelName;

        $guard = config('auth.defaults.guard');
        $provider = config("auth.guards.{$guard}.provider");
        $modelPath = config("auth.providers.{$provider}.modelPath");

        return [$modelPath . $modelName, $modelName];
    }


    /**
     * Alphabetically sorts the imports for the given stub.
     *
     * @param string $stub
     * @return string
     */
    protected function sortImports($stub)
    {
        if (preg_match('/(?P<imports>(?:use [^;]+;$\n?)+)/m', $stub, $match)) {
            $imports = explode("\n", trim($match['imports']));

            sort($imports);

            return str_replace(trim($match['imports']), implode("\n", $imports), $stub);
        }

        return $stub;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->laravel->getNamespace();
    }

    /**
     * Get the model for the default guard's user provider.
     *
     * @return string|null
     */
    protected function userProviderModel()
    {
        $guard = config('auth.defaults.guard');

        $provider = config("auth.guards.{$guard}.provider");

        return config("auth.providers.{$provider}.model");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
          ['name', InputArgument::REQUIRED, 'The name of the class'],
        ];
    }


    /**
     * change anme
     * 
     * @param $name
     * @return string
     */
    public function changeName($name)
    {
        return strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $name));
    }


}

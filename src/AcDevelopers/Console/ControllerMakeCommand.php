<?php

namespace AcDevelopers\ArtisanGenerator\Console;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ControllerMakeCommand
 *
 * @package AcDevelopers\ArtisanGenerator\Console
 */
class ControllerMakeCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ac:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stub = null;

        if ($this->option('parent')) {
            $stub = '/stubs/controller.nested.stub';
        } elseif ($this->option('model')) {
            $stub = '/stubs/controller.model.stub';
        } elseif ($this->option('invokable')) {
            $stub = '/stubs/controller.invokable.stub';
        } elseif ($this->option('resource')) {
            $stub = '/stubs/controller.stub';
        }

        if ($this->option('api') && is_null($stub)) {
            $stub = '/stubs/controller.api.stub';
        } elseif ($this->option('api') && ! is_null($stub) && ! $this->option('invokable')) {
            $stub = str_replace('.stub', '.api.stub', $stub);
        }

        $stub = $stub ?? '/stubs/controller.plain.stub';

        return __DIR__.$stub;
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        if (parent::handle() === false) {
            return false;
        }

        if ($this->confirm('Would you like to route this controller?', true)) {
            $this->createRoute();
        }
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.config('ac-developers.generator.namespaces.controllers', '\Http\Controllers');
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param string $name
     * @return mixed|string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        if ($this->option('parent')) {
            $replace = $this->buildParentReplacements();
        }

        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }

        if ($this->getStub() !== '/stubs/controller.plain.stub'
            && $this->confirm('Would you like to use a custom form request for this controller?', true)) {
            $replace = $this->buildRequestReplacements($replace, $this->ask('Request name'));
        }

        $replace["use {$controllerNamespace}\Controller;\n"] = $controllerNamespace == 'App\Http\Controllers'
            ? '' : "use App\Http\Controllers\Controller;\n";

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Build the replacements for a parent controller.
     *
     * @return array
     */
    protected function buildParentReplacements()
    {
        $parentModelClass = $this->parseClass($this->option('parent'), config('ac-developers.generator.namespaces.models', ''));

        if (! class_exists($parentModelClass)) {
            if ($this->confirm("A {$parentModelClass} model does not exist. Do you want to generate it?", true)) {
                $params = ['name' => $parentModelClass];
                $this->call('ac:model', $params);
            }
        }

        return [
            'ParentDummyFullModelClass' => $parentModelClass,
            'ParentDummyModelClass' => class_basename($parentModelClass),
            'ParentDummyModelVariable' => lcfirst(class_basename($parentModelClass)),
        ];
    }

    /**
     * Build the request replacement values.
     *
     * @param  array  $replace
     * @param string $name
     * @return array
     */
    protected function buildRequestReplacements(array $replace, $name)
    {
        $requestClass = $this->parseClass($name, config('ac-developers.generator.namespaces.requests', '\Requests'));

        if (! class_exists($requestClass)) {
            if ($this->confirm("A {$requestClass} request does not exist. Do you want to generate it?", true)) {
                $this->call('ac:request', ['name' => $requestClass, '--resource' => true]);
            }
        }

        return array_merge($replace, [
            'use Illuminate\Http\Request' => "use {$requestClass} as Request",
            '\Illuminate\Http\Request' => 'Request',
        ]);
    }

    /**
     * Create a route for this controller.
     *
     * @return void
     */
    protected function createRoute(): void
    {
        $params = [];

        $params['--file'] = $this->ask('Where would you like to save the generated route, "api" or "web"?', 'web');

        $params['name'] = $this->ask('Please provide a name for this controller route', '');

        $params['--controller'] = $this->getDefaultNamespace(
                Str::replaceLast('\\', '', $this->rootNamespace())).'\\'.$this->getNameInput();

        $this->option('api') ? $params['--api'] = true : null;

        $this->call('ac:route', $params);
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a resource controller for the given model.'],
            ['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller class.'],
            ['invokable', 'i', InputOption::VALUE_NONE, 'Generate a single method, invokable controller class.'],
            ['parent', 'p', InputOption::VALUE_OPTIONAL, 'Generate a nested resource controller class.'],
            ['api', null, InputOption::VALUE_NONE, 'Exclude the create and edit methods from the controller.'],
        ];
    }
}

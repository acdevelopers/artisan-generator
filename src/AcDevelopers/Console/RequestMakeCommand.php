<?php

namespace AcDevelopers\ArtisanGenerator\Console;

use Symfony\Component\Console\Input\InputOption;

/**
 * Class RequestMakeCommand
 *
 * @package AcDevelopers\ArtisanGenerator\Console
 */
class RequestMakeCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ac:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form request class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->option('resource')
            ? __DIR__ . '/stubs/request.resource.stub'
            : __DIR__ . '/stubs/request.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.config('ac-developers.generator.namespaces.requests', '\Http\Requests');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource request class.']
        ];
    }
}

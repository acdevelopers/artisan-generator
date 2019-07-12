<?php

namespace AcDevelopers\ArtisanGenerator\Console;

use Symfony\Component\Console\Input\InputOption;

/**
 * Class JobMakeCommand
 *
 * @package AcDevelopers\ArtisanGenerator\Console
 */
class JobMakeCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ac:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new job class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Job';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->option('sync')
                        ? __DIR__ . '/stubs/job.stub'
                        : __DIR__.'/stubs/job-queued.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.config('ac-developers.generator.namespaces.jobs', '\Jobs');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['sync', null, InputOption::VALUE_NONE, 'Indicates that job should be synchronous'],
        ];
    }
}

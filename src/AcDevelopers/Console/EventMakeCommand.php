<?php

namespace AcDevelopers\ArtisanGenerator\Console;

/**
 * Class EventMakeCommand
 *
 * @package AcDevelopers\ArtisanGenerator\Console
 */
class EventMakeCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ac:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new event class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Event';

    /**
     * Determine if the class already exists.
     *
     * @param  string  $rawName
     * @return bool
     */
    protected function alreadyExists($rawName)
    {
        return class_exists($rawName);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/event.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.config('ac-developers.generator.namespaces.events', '\Events');
    }
}

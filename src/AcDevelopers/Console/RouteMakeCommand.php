<?php

namespace AcDevelopers\ArtisanGenerator\Console;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class RouteMakeCommand.
 *
 * @package AcDevelopers\ArtisanGenerator\Console
 */
class RouteMakeCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ac:route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new resourceful route';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Route';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/route.stub';
    }

    /**
     * Execute the console command.
     *
     * @return bool|void|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $stub = $this->files->get($this->getStub());

        $stub = $this->replaceDummyPlaceholders($stub);

        $routeFile = $this->option('file')
            ? 'routes/'.str_replace('.php', '', $this->option('file')).'.php' : 'routes/web.php';

        if (! $this->files->isFile(base_path($routeFile))) {

            throw new FileNotFoundException("File does not exist at path {$routeFile}");
        }

        $this->files->append(base_path($routeFile), $stub);

        $this->info("Route was added to {$routeFile} successfully.");
    }

    /**
     * Replace dummy placeholders.
     *
     * @param string $stub
     * @return string
     */
    protected function replaceDummyPlaceholders($stub)
    {
        $controller = str_replace('/', '\\', $this->option('controller'));

        $method = $this->option('api') ? 'apiResource' : 'resource';

        $stub = str_replace(
            ['DummyRouteName', 'DummyNamespacedController', 'DummyRouteMethod'],
            [$this->argument('name'), $controller, $method],
            $stub
        );

        return $stub;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['controller', null, InputOption::VALUE_REQUIRED, 'The controller that is to be routed.'],
            ['api', 'a', InputOption::VALUE_NONE, 'Indicate the type of route to be create.'],
            ['file', 'f', InputOption::VALUE_OPTIONAL, 'Indicate which route file to save the given route, the default is "web.php".']
        ];
    }
}

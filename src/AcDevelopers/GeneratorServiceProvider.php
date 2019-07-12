<?php
namespace AcDevelopers\ArtisanGenerator;

use Illuminate\Support\ServiceProvider;

/**
 * Class GeneratorServiceProvider
 *
 * @package AcDevelopers\ArtisanGenerator
 */
class GeneratorServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/generator.php' => config_path('ac-developers/generator.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../config/generator.php', 'generator');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register commands.
        if ($this->app->runningInConsole()) {
            $this->commands([
                'AcDevelopers\ArtisanGenerator\Console\ChannelMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\ConsoleMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\ControllerMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\EventGenerateCommand',
                'AcDevelopers\ArtisanGenerator\Console\EventMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\ExceptionMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\JobMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\ListenerMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\MailMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\MiddlewareMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\ModelMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\NotificationMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\ObserverMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\PolicyMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\ProviderMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\RequestMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\ResourceMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\RouteMakeCommand',
                'AcDevelopers\ArtisanGenerator\Console\RuleMakeCommand',
            ]);
        }
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

<?php

namespace AcDevelopers\ArtisanGenerator\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class EventGenerateCommand
 *
 * @package AcDevelopers\ArtisanGenerator\Console
 */
class EventGenerateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ac:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the missing events and listeners based on registration';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $providers = $this->laravel->getProviders(EventServiceProvider::class);

        foreach ($providers as $provider) {
            foreach ($provider->listens() as $event => $listeners) {
                $this->makeEventAndListeners($event, $listeners);
            }
        }

        $this->info('Events and listeners generated successfully!');
    }

    /**
     * Make the event and listeners for the given event.
     *
     * @param  string  $event
     * @param  array  $listeners
     * @return void
     */
    protected function makeEventAndListeners($event, $listeners)
    {
        if (! Str::contains($event, '\\')) {
            return;
        }

        $this->callSilent('ac:event', ['name' => $event]);

        $this->makeListeners($event, $listeners);
    }

    /**
     * Make the listeners for the given event.
     *
     * @param  string  $event
     * @param  array  $listeners
     * @return void
     */
    protected function makeListeners($event, $listeners)
    {
        foreach ($listeners as $listener) {
            $listener = preg_replace('/@.+$/', '', $listener);

            $this->callSilent('ac:listener', array_filter(
                ['name' => $listener, '--event' => $event]
            ));
        }
    }
}

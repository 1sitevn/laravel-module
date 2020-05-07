<?php

namespace OneSite\Module;

use Illuminate\Support\ServiceProvider;
use OneSite\Module\Commands\ModuleMakeCommand;

/**
 * Class ModuleGeneratorServiceProvider
 * @package DrawMyAttention\ResourceGenerator
 */
class ModuleGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.onesite.make_module', function ($app) {
            return $app[ModuleMakeCommand::class];
        });
        $this->commands('command.onesite.make_module');
    }
}

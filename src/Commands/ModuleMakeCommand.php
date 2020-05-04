<?php

namespace Onesite\Module\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;

class ModuleMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name : The module name} {attributes?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module with model, migration, controller and add routes';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;

    /**
     * @var Composer
     */
    private $composer;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     * @param Composer $composer
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = trim($this->input->getArgument('name'));

        $this->appendRoutes($name);
    }

    private function appendRoutes($moduleName)
    {
        $moduleTitle = ucfirst($moduleName);

        $newRoutes = $this->files->get(__DIR__ . '/../Stubs/routes.stub');

        $newRoutes = str_replace('|MODEL_TITLE|', $moduleTitle, $newRoutes);

        $this->files->append(
            app_path('Http/routes.php'),
            $newRoutes
        );

        $this->info('Added routes for ' . $moduleTitle);
    }

}

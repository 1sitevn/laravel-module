<?php

namespace OneSite\Module\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;

/**
 * Class ModuleMakeCommand
 * @package OneSite\Module\Commands
 */
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
     * @var
     */
    private $moduleName;

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
     * @return bool
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->moduleName = strtolower(trim($this->input->getArgument('name')));

        $modulePath = $this->getModulePath();
        if ($this->files->exists($modulePath)) {
            $this->error('Module ' . $this->moduleName . ' is exists');

            return false;
        }

        $this->createRoutes();
        $this->createControllers();
        $this->createResources();
        $this->createEvents();
        $this->createProviders();
        $this->createConsoles();
        $this->createModels();
        $this->createHelpers();
        $this->createConfigs();
        $this->createOthers();
    }


    /**
     * @param string $suffix
     * @return string
     */
    private function getModulePath($suffix = '')
    {
        return base_path("modules/" . $this->moduleName) . (strpos($suffix, '/') === 0 ? $suffix : '/' . $suffix);
    }

    /**
     * @return string
     */
    private function getModuleTitle()
    {
        return ucfirst($this->moduleName);
    }

    /**
     * @param $filePath
     * @param $content
     */
    private function putFileContent($filePath, $content)
    {
        $dirname = dirname($filePath);

        if (!$this->files->exists($dirname)) {
            $this->files->makeDirectory($dirname, 0755, true);
        }

        $this->files->put($filePath, $content);
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createRoutes()
    {
        $newRoutes = $this->files->get(__DIR__ . '/../Stubs/routes.stub');

        $newRoutes = str_replace('MODULE_NAME', $this->moduleName, $newRoutes);
        $newRoutes = str_replace('MODULE_TITLE', $this->getModuleTitle(), $newRoutes);

        $this->putFileContent($this->getModulePath('routes.php'), $newRoutes);

        $this->info('Added routes for ' . $this->getModuleTitle());
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createControllers()
    {
        $baseController = $this->files->get(__DIR__ . '/../Stubs/app/Http/Controllers/BaseController.stub');
        $testController = $this->files->get(__DIR__ . '/../Stubs/app/Http/Controllers/ExampleController.stub');

        $baseController = str_replace('MODULE_TITLE', $this->getModuleTitle(), $baseController);
        $testController = str_replace('MODULE_TITLE', $this->getModuleTitle(), $testController);
        $testController = str_replace('ControllerClass', 'ExampleController', $testController);

        $this->putFileContent($this->getModulePath('app/Http/Controllers/BaseController.php'), $baseController);
        $this->putFileContent($this->getModulePath('app/Http/Controllers/ExampleController.php'), $testController);
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createResources()
    {
        $testView = $this->files->get(__DIR__ . '/../Stubs/resources/views/example.blade.stub');

        $this->putFileContent($this->getModulePath('resources/views/example.blade.php'), $testView);
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createProviders()
    {
        $appServiceProvider = $this->files->get(__DIR__ . '/../Stubs/app/Providers/AppServiceProvider.stub');
        $eventServiceProvider = $this->files->get(__DIR__ . '/../Stubs/app/Providers/EventServiceProvider.stub');

        $appServiceProvider = str_replace('MODULE_TITLE', $this->getModuleTitle(), $appServiceProvider);
        $eventServiceProvider = str_replace('MODULE_TITLE', $this->getModuleTitle(), $eventServiceProvider);

        $this->putFileContent($this->getModulePath('app/Providers/AppServiceProvider.php'), $appServiceProvider);
        $this->putFileContent($this->getModulePath('app/Providers/EventServiceProvider.php'), $eventServiceProvider);
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createEvents()
    {
        $event = $this->files->get(__DIR__ . '/../Stubs/app/Events/ExampleEvent.stub');
        $listener = $this->files->get(__DIR__ . '/../Stubs/app/Listeners/ExampleListener.stub');

        $event = str_replace('MODULE_TITLE', $this->getModuleTitle(), $event);
        $listener = str_replace('MODULE_TITLE', $this->getModuleTitle(), $listener);

        $this->putFileContent($this->getModulePath('app/Events/ExampleEvent.php'), $event);
        $this->putFileContent($this->getModulePath('app/Listeners/ExampleListener.php'), $listener);
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createConsoles()
    {
        $command = $this->files->get(__DIR__ . '/../Stubs/app/Console/Commands/ExampleCommand.stub');

        $command = str_replace('MODULE_TITLE', $this->getModuleTitle(), $command);

        $this->putFileContent($this->getModulePath('app/Console/Commands/ExampleCommand.php'), $command);
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createModels()
    {
        $model = $this->files->get(__DIR__ . '/../Stubs/app/Models/ExampleModel.stub');

        $model = str_replace('MODULE_TITLE', $this->getModuleTitle(), $model);

        $this->putFileContent($this->getModulePath('app/Models/ExampleModel.php'), $model);
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createHelpers()
    {
        $helper = $this->files->get(__DIR__ . '/../Stubs/helpers.stub');

        $helper = str_replace('MODULE_NAME', $this->moduleName, $helper);

        $this->putFileContent($this->getModulePath('helpers.php'), $helper);
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createConfigs()
    {
        $config = $this->files->get(__DIR__ . '/../Stubs/configs/example.stub.php');

        $this->putFileContent($this->getModulePath('configs/modules/' . $this->moduleName . '.php'), $config);
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createOthers()
    {
        $this->files->makeDirectory($this->getModulePath('databases'), 0755, true);
    }
}

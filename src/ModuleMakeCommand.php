<?php

namespace OneSite\Module;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Illuminate\Filesystem\Filesystem;

/**
 * Class ModuleMakeCommand
 *
 * @package OneSite\Module
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
     * @var FileGenerator
     */
    private $fileGenerator;

    /**
     * @var
     */
    private $moduleName;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;

        $this->fileGenerator = new FileGenerator();
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
        $this->createContracts();
        $this->createControllers();
        $this->createResources();
        $this->createEvents();
        $this->createProviders();
        $this->createConsoles();
        $this->createModels();
        $this->createHelpers();
        $this->createConfigs();
        $this->createServices();
        $this->createOthers();
    }


    /**
     * @param  string $suffix
     * @return string
     */
    private function getModulePath($suffix = '')
    {
        return base_path("modules/" . $this->moduleName) . (strpos($suffix, '/') === 0 ? $suffix : '/' . $suffix);
    }

    /**
     * @return string
     */
    private function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * @return string
     */
    private function getModuleTitle()
    {
        return ucfirst($this->moduleName);
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createRoutes()
    {
        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/routes.stub',
            $this->getModulePath('routes.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createControllers()
    {
        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Http/Controllers/BaseController.stub',
            $this->getModulePath('app/Http/Controllers/BaseController.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );

        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Http/Controllers/ExampleController.stub',
            $this->getModulePath('app/Http/Controllers/ExampleController.php'),
            ['MODULE_NAME', 'MODULE_TITLE', 'ControllerClass'],
            [$this->getModuleName(), $this->getModuleTitle(), 'ExampleController']
        );
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createResources()
    {
        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/resources/views/example.blade.stub',
            $this->getModulePath('resources/views/example.blade.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createProviders()
    {
        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Providers/AppServiceProvider.stub',
            $this->getModulePath('app/Providers/AppServiceProvider.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );

        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Providers/EventServiceProvider.stub',
            $this->getModulePath('app/Providers/EventServiceProvider.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createEvents()
    {
        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Events/ExampleEvent.stub',
            $this->getModulePath('app/Events/ExampleEvent.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );

        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Listeners/ExampleListener.stub',
            $this->getModulePath('app/Listeners/ExampleListener.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createConsoles()
    {
        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Console/Commands/ExampleCommand.stub',
            $this->getModulePath('app/Console/Commands/ExampleCommand.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createModels()
    {
        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Models/Example.stub',
            $this->getModulePath('app/Models/Example.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createContracts()
    {
        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Contracts/Models/BaseModelInterface.stub',
            $this->getModulePath('app/Contracts/Models/BaseModelInterface.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );

        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Contracts/Models/ExampleModelInterface.stub',
            $this->getModulePath('app/Contracts/Models/ExampleModelInterface.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createServices()
    {
        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Services/Models/BaseModelService.stub',
            $this->getModulePath('app/Services/Models/BaseModelService.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );

        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/app/Services/Models/ExampleModelService.stub',
            $this->getModulePath('app/Services/Models/ExampleModelService.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createHelpers()
    {
        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/helpers.stub',
            $this->getModulePath('helpers.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function createConfigs()
    {
        $this->fileGenerator->generator(
            __DIR__ . '/Stubs/configs/example.stub.php',
            $this->getModulePath('configs/modules/' . $this->moduleName . '.php'),
            ['MODULE_NAME', 'MODULE_TITLE'],
            [$this->getModuleName(), $this->getModuleTitle()]
        );
    }

    /**
     *
     */
    private function createOthers()
    {
        $this->files->makeDirectory($this->getModulePath('databases'), 0755, true);
    }
}

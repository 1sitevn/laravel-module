<?php

namespace OneSite\Module\Commands;

use Modules\Admin\Events\ExampleEvent;
use Modules\Admin\Providers\AppServiceProvider;
use Modules\Admin\Providers\EventServiceProvider;
use Orchestra\Testbench\TestCase;

require_once "helpers.php";

/**
 * Class ModuleAdminTest
 * @package OneSite\Module\Commands
 */
class ModuleAdminTest extends TestCase
{
    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            AppServiceProvider::class,
            EventServiceProvider::class
        ];
    }

    /**
     * PHPUnit test: vendor/bin/phpunit --filter testModuleControllers tests/ModuleAdminTest.php
     */
    public function testModuleControllers()
    {
        // Visit /test/admin and see "Laravel Admin Module" on it
        $response = $this->get('test/admin');

        $response->assertStatus(200);
        $response->assertSee('Laravel Admin Module');
    }

    /**
     * PHPUnit test: vendor/bin/phpunit --filter testModuleCommands tests/ModuleAdminTest.php
     */
    public function testModuleCommands()
    {
        $this->artisan('module:example')->assertExitCode(0);
        ;
    }

    /**
     * PHPUnit test: vendor/bin/phpunit --filter testModuleEvents tests/ModuleAdminTest.php
     */
    public function testModuleEvents()
    {
        event(new ExampleEvent(['title' => 'Admin module title test.']));

        $this->assertTrue(true);
    }

    /**
     * PHPUnit test: vendor/bin/phpunit --filter testModuleHelpers tests/ModuleAdminTest.php
     */
    public function testModuleHelpers()
    {
        $this->assertEquals('admin', module_admin_test_function());
    }
}

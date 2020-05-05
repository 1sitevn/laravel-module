<?php

namespace OneSite\Module\Commands;

use Modules\Admin\Providers\AppServiceProvider;
use Orchestra\Testbench\TestCase;

require_once "helpers.php";

class ModuleRouteTest extends TestCase
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
            AppServiceProvider::class
        ];
    }

    /**
     * PHPUnit test: vendor/bin/phpunit --filter testModuleRoute tests/ModuleRouteTest.php
     */
    public function testModuleRoute()
    {
        // Visit /test/admin and see "Laravel Admin Module" on it
        $response = $this->get('test/admin');

        $response->assertStatus(200);
        $response->assertSee('Laravel Admin Module');
    }

}